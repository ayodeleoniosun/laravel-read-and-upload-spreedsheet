<?php

namespace App\Http\Repositories;

use App\Exceptions\ContractNotFoundException;
use App\Exceptions\EmptySheetException;
use App\Exceptions\FileTooLargeException;
use App\Exceptions\NoContractFoundException;
use App\Http\Interfaces\ContractInterface;
use App\Http\Models\Contract;
use App\Jobs\ImportContract;
use App\Mails\SendImportReportMail;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ContractRepository implements ContractInterface
{
    const MAX_UPLOAD = 250;

    public function index(object $request) : array
    {
        $contracts = Contract::query();

        if ($request->filled('search')) {
            $q = $request->search;
            
            $contracts = $contracts->where(function ($query) use ($q) {
                $query->where('agreement_date', 'LIKE', '%' . $q . '%')
                    ->orWhere('amount', 'LIKE', '%' . $q . '%')
                    ->orWhere('winning_company', 'LIKE', '%' . $q . '%');
            });
        }

        $contracts = $contracts->orderBy('created_at', 'DESC')->paginate(50);

        if ($contracts->count() == 0) {
            throw new NoContractFoundException();
        }

        return [
            'status' => 'success',
            'contracts' => $contracts
        ];
    }

    public function find(int $id, string $status = null) : array
    {
        $contract = Contract::find($id);

        if (!$contract) {
            throw new ContractNotFoundException();
        }

        if ($status === 'status') {
            return [
                'status' => 'success',
                'contract_status' => $contract->status
            ];
        }
        
        $contract->status = 'read';
        $contract->save();

        return [
            'status' => 'success',
            'contracts' => $contract
        ];
    }
    
    public function upload(object $request): array
    {
        $file = $request->file;
        $extension = $file->getClientOriginalExtension();
        $path = $file->getRealPath();
        $reader = IOFactory::createReader(ucfirst($extension));
        $spreadsheet = $reader->load($path);

        $contract = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $countTotalRows = count($contract) - 1;
        
        if ($countTotalRows < 1) {
            throw new EmptySheetException();
        }

        if ($countTotalRows > self::MAX_UPLOAD) {
            throw new FileTooLargeException('You cannot upload more than '.self::MAX_UPLOAD.' records at a time.');
        }

        $sheetNames = $spreadsheet->getSheetNames();
        $reader->setLoadSheetsOnly($sheetNames[0]);
        unset($contract[1]);
        
        ImportContract::dispatch(array_values($contract));

        return [
            'status' => 'success',
            'message' => 'Uploading contract data. You will be notified via mail upon successful completion of the upload.'
        ];
    }

    public function store($contracts)
    {
        $successfulData = [];
        $failedData = [];

        foreach ($contracts as $contract) {
            $data = (object) $contract;
            $contractExists = Contract::where('contract_id', $data->contract_id)->exists();

            if (!$contractExists) {
                Contract::create([
                    'contract_id' => $data->contract_id,
                    'announcement' => $data->announcement,
                    'contract_type' => $data->contract_type,
                    'procedure_type' => $data->procedure_type,
                    'contract_object' => $data->contract_object,
                    'adjudicators' => $data->adjudicators,
                    'winning_company' => $data->winning_company,
                    'publication_date' => $data->publication_date,
                    'agreement_date' => $data->agreement_date,
                    'amount' => $data->amount,
                    'cpv' => $data->cpv,
                    'deadline' => $data->deadline,
                    'location' => $data->location,
                    'reasoning' => $data->reasoning
                ]);

                $successfulData[] = $data->contract_id;
            } else {
                $failedData[] = $data->contract_id;
            }
        }

        $data = [
            'successful' => $successfulData,
            'failed' => $failedData
        ];

        $emailAddress = config('constants.admin_email_address');
        Mail::to($emailAddress)->queue((new SendImportReportMail($data))->onQueue('import_report'));
    }
}
