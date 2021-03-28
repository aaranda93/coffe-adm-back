<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Contract;
class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {

            $table->uuid('id')->unique();
            $table->uuid('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->uuid('branch_id')->nullable();
            $table->foreign('branch_id')
                ->references('id')
                ->on('branches');
            $table->integer('status')->default(Contract::ACTIVE);
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
        Schema::dropIfExists('contracts');
    }
}
