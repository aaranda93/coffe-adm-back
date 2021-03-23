<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('entity_id');
            $table->foreign('entity_id')
                ->references('id')
                ->on('entities');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('url_pic');
            $table->string('url_pic_min');
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
        Schema::dropIfExists('branches');
    }
}
