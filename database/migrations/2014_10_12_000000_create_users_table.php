<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->string('name');
            $table->string('phone',10);
            $table->string('line')->nullable();
            $table->string('currency');
            $table->string('how_to_know');
            $table->string('how_to_know_desc')->nullable();
            $table->string('verified')->nullable();
            $table->enum('is_verified', ['N', 'Y'])->default('N')->nullable();
            $table->enum('is_active', ['N', 'Y'])->default('N')->nullable();
            $table->string('status',2)->nullable();
            $table->rememberToken();
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
