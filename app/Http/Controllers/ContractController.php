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

    public function index(Request $request)
    {
        $response = $this->contractInterface->index($request);
        return response()->json($response, 200);
    }

    public function find(int $id, string $status = null)
    {
        $response = $this->contractInterface->find($id, $status);
        return response()->json($response, 200);
    }

    public function upload(ContractUploadRequest $request)
    {
        $extension = $request->file('file')->getClientOriginalExtension();
        $allowedExtensions = ['xls', 'xlsx'];

        if (!in_array($extension, $allowedExtensions)) {
            throw new InvalidFileException();
        }

        $response = $this->contractInterface->upload((object) $request->all());
        return response()->json($response, 201);
    }
}
