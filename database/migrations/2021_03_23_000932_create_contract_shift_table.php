<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_shift', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('contract_id');
            $table->foreign('contract_id')
                ->references('id')
                ->on('contracts');
            $table->uuid('shift_id');
            $table->foreign('shift_id')
                ->references('id')
                ->on('shifts');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_shift');
    }
}
