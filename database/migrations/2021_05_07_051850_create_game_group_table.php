<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('is_active', ['N', 'Y'])->default('Y')->nullable();
            $table->string('status', 2)->default('CO')->nullable();
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
        Schema::dropIfExists('game_group');
    }
}
