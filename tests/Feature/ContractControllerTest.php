<?php

namespace Tests\Feature;

use App\Jobs\ImportContract;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Tests\Traits\Contract as TraitsContract;
use Tests\TestCase;

class ContractControllerTest extends TestCase
{
    use DatabaseTransactions,TraitsContract;
    
    public function setUp(): void
    {
        parent::setup();
    }

    public function testUploadContractSuccessful()
    {
        Queue::fake();
        $response = $this->uploadFile();
        $response->assertStatus(201);
        $this->assertEquals($response->json('status'), 'success');
        $this->assertEquals($response->json('message'), 'Uploading contract data. You will be notified via mail upon successful completion of the upload.');

        Queue::assertPushed(ImportContract::class);
    }

    public function testShowAllContracts()
    {
        $this->uploadFile();
        $response = $this->json('GET', $this->route("/contracts"));
        $response->assertStatus(200);
        $this->assertEquals($response->json('status'), 'success');
        $response->assertJsonStructure([
            'status',
            'contracts' => [
                'current_page',
                'data' => [
                    '*' => ['id', 'contract_id', 'announcement', 'contract_type', 'procedure_type',
                    'contract_object', 'adjudicators', 'winning_company', 'publication_date', 'agreement_date',
                    'amount', 'cpv', 'deadline', 'location', 'reasoning', 'status', 'created_at', 'updated_at', 'deleted_at'],
                ],
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]
        ]);
    }

    public function testSearchContractFound()
    {
        $this->uploadFile();
        $response = $this->json('GET', $this->route("/contracts/?search=lda"));
        $response->assertStatus(200);
        $this->assertEquals($response->json('status'), 'success');
        $response->assertJsonStructure([
            'status',
            'contracts' => [
                'current_page',
                'data' => [
                    '*' => ['id', 'contract_id', 'announcement', 'contract_type', 'procedure_type',
                    'contract_object', 'adjudicators', 'winning_company', 'publication_date', 'agreement_date',
                    'amount', 'cpv', 'deadline', 'location', 'reasoning', 'status', 'created_at', 'updated_at', 'deleted_at'],
                ],
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]
        ]);
    }

    public function testSearchContractNotFound()
    {
        $response = $this->json('GET', $this->route("/contracts/?search=testtt"));
        $response->assertStatus(404);
        $this->assertEquals($response->json('status'), 'error');
        $this->assertEquals($response->json('message'), 'No contract found');
    }

    public function testFindAndReadContractFound()
    {
        $this->uploadFile();
        $response = $this->json('GET', $this->route("/contracts/1"));
        $response->assertStatus(200);
        $this->assertEquals($response->json('status'), 'success');
        $this->assertEquals($response->json('contracts.status'), 'read');
        $response->assertJsonStructure([
            'status',
            'contracts' => ['id', 'contract_id', 'announcement', 'contract_type', 'procedure_type',
                'contract_object', 'adjudicators', 'winning_company', 'publication_date', 'agreement_date',
                'amount', 'cpv', 'deadline', 'location', 'reasoning', 'status', 'created_at', 'updated_at', 'deleted_at'],
        ]);
    }

    public function testFindAndReadContractNotFound()
    {
        $response = $this->json('GET', $this->route("/contracts/1000"));
        $response->assertStatus(404);
        $this->assertEquals($response->json('status'), 'error');
        $this->assertEquals($response->json('message'), 'Contract not found');
    }

    public function testGetContractStatusFound()
    {
        $this->uploadFile();
        $response = $this->json('GET', $this->route("/contracts/10/status"));
        $response->assertStatus(200);
        $this->assertEquals($response->json('status'), 'success');
        $this->assertEquals($response->json('contract_status'), 'unread');
    }

    public function testGetContractStatusNotFound()
    {
        $response = $this->json('GET', $this->route("/contracts/1000/status"));
        $response->assertStatus(404);
        $this->assertEquals($response->json('status'), 'error');
        $this->assertEquals($response->json('message'), 'Contract not found');
    }
}
