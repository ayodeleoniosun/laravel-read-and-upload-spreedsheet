<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidFileException;
use App\Http\Interfaces\ContractInterface;
use Illuminate\Http\Request;
use App\Http\Requests\ContractUploadRequest;

class ContractController extends Controller
{
    protected $contractInterface;

    public function __construct(ContractInterface $contractInterface)
    {
        $this->contractInterface = $contractInterface;
    }

    public function upload(ContractUploadRequest $request)
    {
        if ($request->file('file')->getClientOriginalExtension() !== 'xlsx') {
            throw new InvalidFileException();
        }

        $response = $this->contractInterface->upload((object) $request->all());
        return response()->json($response, 201);
    }
}
