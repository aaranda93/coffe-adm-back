<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_role', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('contract_id');
            $table->foreign('contract_id')
                ->references('id')
                ->on('contracts');
            $table->uuid('role_id');
            $table->foreign('role_id')
                ->references('id')
                ->on('roles');
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
        Schema::dropIfExists('contract_role');
    }
}
