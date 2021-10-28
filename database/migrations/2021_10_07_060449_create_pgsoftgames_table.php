<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePgsoftgamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pgsoftgames', function (Blueprint $table) {
            $table->id();
            $table->string('operator_token');
            $table->string('secret_key');
            $table->string('pgsoft_api_domain');
            $table->string('datagrab_api_domain');
            $table->string('pgsoft_public_domain');
            $table->string('history_interpreter');
            $table->string('url_scheme');
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
        Schema::dropIfExists('pgsoftgames');
    }
}
