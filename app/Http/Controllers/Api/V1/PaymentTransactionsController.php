<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\PaymentTransactionLog;

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
                    ->leftJoin('games as from_game', 'from_wallet.game_id', '=', 'from_game.id')
                    ->leftJoin('games as to_game', 'to_wallet.game_id', '=', 'to_game.id')
                    ->select('payment_transactions.*', 'payment_transactions.staff_id as by_admin',
                            'c_bank_accounts.bank_id as bank_name', 'c_bank_accounts.account_name', 'c_bank_accounts.account_number',
                            'user_bankings.bank_id as user_bank_name', 'user_bankings.bank_account_name', 'user_bankings.bank_account_number',
                            'from_game.name as from_game', 'from_wallet.is_default as from_default', 'from_wallet.id as from_id',
                            'to_game.name as to_game', 'to_wallet.is_default as to_default', 'to_wallet.id as to_id'
                            )
                    ->where('payment_transactions.user_id', $accessToken->user_id)
                    ->orderBy('payment_transactions.created_at', 'desc')
                    ->get();

        $is_trans = json_decode($trans, true);
        $transaction = [];
        foreach($is_trans as $key => $tran) {
            if($tran['user_bank_name'] != '') {
                $user_bank_name = $this->getBanks($tran['user_bank_name']);
                $tran['user_bank_name'] = $user_bank_name->name;
            }
            if($tran['bank_name'] != '') {
                $bank_name = $this->getBanks($tran['bank_name']);
                $tran['bank_name'] = $bank_name->name;
            }
            
            array_push($transaction, $tran);
        }
        
        return response()->json(['histories' => $transaction, 'status' => 200], 200);
    }

    private function getBanks($id)
    {
        return DB::table('banks')->find($id);
    }
}
