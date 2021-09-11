<?php

namespace App\Jobs;

use App\Http\Repositories\ContractRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Request;

class ImportContract implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    public $timeout = 600; //timeout after 10 mins
    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->data as $data) {
            $contracts[] = [
                'contract_id' => $data['A'],
                'announcement' => $data['B'],
                'contract_type' => $data['C'],
                'procedure_type' => $data['D'],
                'contract_object' => $data['E'],
                'adjudicators' => $data['F'],
                'winning_company' => $data['G'],
                'publication_date' => $data['H'],
                'agreement_date' => $data['I'],
                'amount' => $data['J'],
                'cpv' => $data['K'],
                'deadline' => $data['L'],
                'location' => $data['M'],
                'reasoning' => $data['N']
            ];
        }

        app(ContractRepository::class)->store($contracts);
    }
}
