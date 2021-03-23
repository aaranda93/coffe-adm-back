<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_detail', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('bill_id');
            $table->foreign('bill_id')
                ->references('id')
                ->on('bills');
            $table->uuid('branch_product_id');
            $table->foreign('branch_product_id')
                ->references('id')
                ->on('branch_product');
            $table->integer('gross_total');
            $table->integer('discount');
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
        Schema::dropIfExists('bill_detail');
    }
}
