<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentTransactionTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_transactions', function (Blueprint $table) {
            $table->bigInteger('user_banking_id')->nullable()->after('c_bank_account_id');
            $table->bigInteger('from_wallet_id')->nullable()->after('user_banking_id');
            $table->bigInteger('to_wallet_id')->nullable()->after('from_wallet_id');

            $table->bigInteger('c_bank_account_id')->nullable()->change();
            $table->string('slip')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
