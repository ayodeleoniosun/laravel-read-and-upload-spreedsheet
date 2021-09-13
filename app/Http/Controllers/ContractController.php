<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidFileException;
use App\Http\Interfaces\ContractInterface;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    protected $contractInterface;

    public function __construct(ContractInterface $contractInterface)
    {
        $this->contractInterface = $contractInterface;
    }

    /**
     * Upload contracts
     *
     * @OA\Post(
     *      path="/contracts/upload",
     *      summary="Upload contract",
     *      description="Upload contract",
     *      tags={"Contracts"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="file",
     *                     type="file",
     *                ),
     *                 required={"file"}
     *             )
     *         )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful login",
     *          content={
     *              @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="string",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                    )
     *                 )
     *              }
     *       ),
     *      @OA\Response(
     *              response=400,
     *              description="Bad request",
     *              content={
     *              @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="string",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                    )
     *                 )
     *              }
     *      ),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=500, description="An error occured"),
     *
     * )
     *
     */


    public function upload(Request $request)
    {
        $body = $request->all();
        
        if (!$request->file) {
            throw new InvalidFileException();
        }

        $extension = $request->file('file')->getClientOriginalExtension();
        $allowedExtensions = ['xls', 'xlsx'];

        if (!in_array($extension, $allowedExtensions)) {
            throw new InvalidFileException();
        }

        $response = $this->contractInterface->upload((object) $body);
        return response()->json($response, 201);
    }

    /**
     * Show All Contracts
     *
     * @OA\Get(
     *      path="/contracts",
     *      tags={"Contracts"},
     *      summary="Get list of contracts",
     *      description="Returns list of contracts",
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          content={
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(
        *                  property="status",
        *                  type="string",
        *                  description="The response code"
     *                 ),
     *                 @OA\Property(
     *                      type="array",
     *                      property="contracts",
     *                      description="The response data",
     *                      @OA\Items()
     *                  ),
     *              )
     *           )
     *         }
     *      ),
     *
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource not found"),
     *      @OA\Response(response=500, description="An error occured."),
     *     )
     */


    /**
    * Search
    *
    * @OA\Get(
    *      path="/contracts?search={searchTerm}",
    *      tags={"Contracts"},
    *      summary="Search contract by date (dataCelebracaoContrato), amount (range) (precoContratual), winning company (adjudicatarios)",
    *      description="Returns search result",
    *
    *       @OA\Parameter(
     *          name="search",
     *          description="search term",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *
    *      @OA\Response(
    *          response=200,
    *          description="Successful operation",
    *          content={
    *              @OA\MediaType(
    *                  mediaType="application/json",
    *              @OA\Schema(
    *                @OA\Property(
    *                  property="status",
    *                  type="string",
    *                  description="The response code"
    *                 ),
    *                 @OA\Property(
    *                      type="array",
    *                      property="contracts",
    *                      description="The response data",
    *                      @OA\Items()
    *                  ),
    *              )
    *           )
    *         }
    *      ),
    *
    *      @OA\Response(response=400, description="Bad request"),
    *      @OA\Response(response=404, description="Resource not found"),
    *      @OA\Response(response=500, description="An error occured."),
    *     )
    */


    public function index(Request $request)
    {
        $response = $this->contractInterface->index($request);
        return response()->json($response, 200);
    }

    /**
     * Find contract
     *
     * @OA\Get(
     *      path="/contracts/{id}",
     *      tags={"Contracts"},
     *      summary="Find contract",
     *      description="Returns details of a single contract",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="contract id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          content={
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(
        *                  property="status",
        *                  type="string",
        *                  description="The response code"
     *                 ),
     *                 @OA\Property(
     *                      type="array",
     *                      property="contract",
     *                      description="The response data",
     *                      @OA\Items()
     *                  ),
     *              )
     *           )
     *         }
     *      ),
     *
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource not found"),
     *      @OA\Response(response=500, description="An error occured."),
     *     )
     */



    /**
     * Find contract status
     *
     * @OA\Get(
     *      path="/contracts/{id}/status",
     *      tags={"Contracts"},
     *      summary="Find contract status",
     *      description="Returns the status of a single contract",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="contract id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          content={
     *              @OA\MediaType(
     *                  mediaType="application/json",
     *              @OA\Schema(
     *                @OA\Property(
        *                  property="status",
        *                  type="string",
        *                  description="The response code"
     *                 ),
     *                 @OA\Property(
     *                      type="array",
     *                      property="contract",
     *                      description="The response data",
     *                      @OA\Items()
     *                  ),
     *              )
     *           )
     *         }
     *      ),
     *
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource not found"),
     *      @OA\Response(response=500, description="An error occured."),
     *     )
     */


    public function find(int $id, string $status = null)
    {
        $response = $this->contractInterface->find($id, $status);
        return response()->json($response, 200);
    }
}
