<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_teams', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('c_league_id')->index();
            $table->string('name');
            $table->string('logo');
            $table->string('code');
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
        Schema::dropIfExists('c_teams');
    }
}
