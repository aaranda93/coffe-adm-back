<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Bill;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('table_id');
            $table->foreign('table_id')
                ->references('id')
                ->on('tables');
            $table->uuid('contract_shift_id');
            $table->foreign('contract_shift_id')
                ->references('id')
                ->on('contract_shift');
            $table->integer('gross_total');
            $table->integer('discount');
            $table->integer('status')->default(Bill::ACTIVE);
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
        Schema::dropIfExists('bills');
    }
}
