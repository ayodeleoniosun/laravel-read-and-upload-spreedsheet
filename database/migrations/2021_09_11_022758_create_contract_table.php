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
            $table->text('contract_id')->unique();
            $table->text('announcement');
            $table->text('contract_type');
            $table->text('procedure_type');
            $table->text('contract_object');
            $table->text('adjudicators');
            $table->text('winning_company');
            $table->text('publication_date');
            $table->text('agreement_date');
            $table->text('amount');
            $table->text('cpv');
            $table->text('deadline');
            $table->text('location');
            $table->text('reasoning');
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
