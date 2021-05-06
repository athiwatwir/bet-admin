<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $trans = DB::table('payment_transactions')
                    ->leftJoin('users', 'payment_transactions.user_id', '=', 'users.id')
                    ->leftJoin('c_bank_accounts', 'payment_transactions.c_bank_account_id', '=', 'c_bank_accounts.id')
                    ->leftJoin('user_bankings', 'payment_transactions.user_banking_id', '=', 'user_bankings.id')
                    ->leftJoin('wallets as from_wallet', 'payment_transactions.from_wallet_id', '=', 'from_wallet.id')
                    ->leftJoin('wallets as to_wallet', 'payment_transactions.to_wallet_id', '=', 'to_wallet.id')
                    ->select('payment_transactions.*', 
                            'users.username', 'users.name',
                            'c_bank_accounts.bank_id as bank_name', 'c_bank_accounts.account_name', 'c_bank_accounts.account_number',
                            'user_bankings.bank_id as user_bank_name', 'user_bankings.bank_account_name', 'user_bankings.bank_account_number',
                            'from_wallet.game_id as from_game', 'from_wallet.is_default as from_default',
                            'to_wallet.game_id as to_game', 'to_wallet.is_default as to_default',
                            )
                    ->orderBy('payment_transactions.created_at', 'desc')
                    ->get();

        return view('transaction.payments', ['transaction'=> $trans]);
    }

    public function confirmPaymentTransaction(Request $request)
    {
        $trans = DB::table('payment_transactions')->find($request->id);

        if($trans->type == 'ฝาก') {

            $wallet = DB::table('wallets')
                            ->where('user_id', $trans->user_id)
                            ->where('is_default', 'Y')
                            ->where('status', 'CO')
                            ->first();

            $wallet_amount = $wallet->amount + $trans->amount;

            DB::table('wallets')->where('id', $wallet->id)->update(['amount' => $wallet_amount]);
            DB::table('payment_transactions')->where('id', $request->id)->update(['status' => 'CO', 'updated_at' => date('Y-m-d h:i:s')]);
            
            $c_bank_account = DB::table('c_bank_accounts')
                                ->where('id', $trans->c_bank_account_id)
                                ->where('is_active', 'N')
                                ->update([
                                    'is_active' => 'Y',
                                    'status' => 'CO'
                                ]);

        }else if($trans->type == 'ถอน') {
            DB::table('payment_transactions')
                    ->where('id', $request->id)
                    ->update([
                        'status' => 'CO', 
                        'updated_at' => date('Y-m-d h:i:s')
                    ]);
        }

        return redirect()->back();
    }

    public function voidPaymentTransaction(Request $request)
    {
        DB::table('payment_transactions')
                ->where('id', $request->id)
                ->update([
                    'status' => 'VO'
                ]);

        return redirect()->back();
    }
}
