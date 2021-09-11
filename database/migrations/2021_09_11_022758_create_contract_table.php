<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract', function (Blueprint $table) {
            $table->id();
            $table->string('contract_id')->unique();
            $table->string('announcement');
            $table->string('contract_type');
            $table->string('procedure_type');
            $table->string('contract_object');
            $table->string('adjudicators');
            $table->string('winning_company');
            $table->string('publication_date');
            $table->string('agreement_date');
            $table->string('amount');
            $table->string('cpv');
            $table->string('deadline');
            $table->string('location');
            $table->string('reasoning');
            $table->enum('status', ['read', 'unread'])->default('unread');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract');
    }
}
