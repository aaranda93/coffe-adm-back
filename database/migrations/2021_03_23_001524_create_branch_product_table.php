<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_product', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('branch_id');
            $table->foreign('branch_id')
                ->references('id')
                ->on('branches');
            $table->uuid('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->integer('price');
            $table->integer('discount');
            $table->integer('stock');
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
        Schema::dropIfExists('branch_product');
    }
}
