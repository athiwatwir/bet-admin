<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transaction_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('payment_transaction_id');
            $table->uuid('user_id')->nullable();
            $table->uuid('staff_id')->nullable();
            $table->uuid('from_wallet_id')->nullable();
            $table->uuid('to_wallet_id')->nullable();
            $table->uuid('c_bank_account_id')->nullable();
            $table->uuid('user_banking_id')->nullable();
            $table->enum('code', ['TRANSFER', 'WITHDRAW', 'DEPOSIT', 'ADJUST', 'FEE'])->nullable();
            $table->string('status', 5)->default('DR')->nullable();
            $table->decimal('amount', 8, 2);
            $table->mediumText('description')->nullable();
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
        Schema::dropIfExists('payment_transaction_logs');
    }
}
