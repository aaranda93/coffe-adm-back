<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('forenames');
            $table->string('surnames');
            $table->string('nid')->unique();
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('url_pic')->nullable();
            $table->string('url_pic_min')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->integer('status')->default(User::ACTIVE);
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
        Schema::dropIfExists('users');
    }
}
