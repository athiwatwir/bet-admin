<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentTransactionsController extends Controller
{
    public function userPaymentTransactions()
    {
        $accessToken = auth()->user()->token();
        $trans = DB::table('payment_transactions')
                    ->leftJoin('c_bank_accounts', 'payment_transactions.c_bank_account_id', '=', 'c_bank_accounts.id')
                    ->leftJoin('user_bankings', 'payment_transactions.user_banking_id', '=', 'user_bankings.id')
                    ->leftJoin('wallets as from_wallet', 'payment_transactions.from_wallet_id', '=', 'from_wallet.id')
                    ->leftJoin('wallets as to_wallet', 'payment_transactions.to_wallet_id', '=', 'to_wallet.id')
                    ->select('payment_transactions.*', 
                            'c_bank_accounts.bank_name', 'c_bank_accounts.account_name', 'c_bank_accounts.account_number',
                            'user_bankings.bank_name as user_bank_name', 'user_bankings.bank_account_name', 'user_bankings.bank_account_number',
                            'from_wallet.game_id as from_game', 'from_wallet.is_default as from_default', 'from_wallet.id as from_id',
                            'to_wallet.game_id as to_game', 'to_wallet.is_default as to_default', 'to_wallet.id as to_id',
                            )
                    ->where('payment_transactions.user_id', $accessToken->user_id)
                    ->orderBy('payment_transactions.created_at', 'desc')
                    ->paginate(20);

        return response()->json(['histories' => $trans, 'status' => 200], 200);
    }
}
