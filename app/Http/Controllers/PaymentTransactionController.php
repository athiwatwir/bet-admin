<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\PaymentTransactionLog;

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
                    ->leftJoin('staffs as admin', 'payment_transactions.staff_id', '=', 'admin.id')
                    ->leftJoin('c_bank_accounts', 'payment_transactions.c_bank_account_id', '=', 'c_bank_accounts.id')
                    ->leftJoin('banks', 'payment_transactions.from_bank_id', '=', 'banks.id')
                    ->leftJoin('user_bankings', 'payment_transactions.user_banking_id', '=', 'user_bankings.id')
                    ->leftJoin('wallets as from_wallet', 'payment_transactions.from_wallet_id', '=', 'from_wallet.id')
                    ->leftJoin('wallets as to_wallet', 'payment_transactions.to_wallet_id', '=', 'to_wallet.id')
                    ->leftJoin('banks as ubank', 'user_bankings.bank_id', '=', 'ubank.id')
                    ->leftJoin('banks as cbank', 'c_bank_accounts.bank_id', '=', 'cbank.id')
                    ->leftJoin('games as from_game', 'from_wallet.game_id', '=', 'from_game.id')
                    ->leftJoin('games as to_game', 'to_wallet.game_id', '=', 'to_game.id')
                    ->select('payment_transactions.*', 
                            'users.username', 'users.name', 'users.currency', 'admin.username as by_admin',
                            'c_bank_accounts.bank_id as bank_name', 'c_bank_accounts.account_name', 'c_bank_accounts.account_number',
                            'banks.name as from_bank_nane', 'banks.name_en as from_bank_name_en',
                            'payment_transactions.account_name as from_account_name', 'payment_transactions.account_number as from_account_number',
                            'user_bankings.bank_id as user_bank_name', 'user_bankings.bank_account_name', 'user_bankings.bank_account_number',
                            'from_game.name as from_game', 'to_game.name as to_game',
                            'from_wallet.is_default as from_default','to_wallet.is_default as to_default',
                            'ubank.name as ubank_name', 'cbank.name as cbank_name',
                            )
                    ->orderBy('payment_transactions.created_at', 'desc')
                    ->paginate(20);

        return view('transaction.payments', ['transaction'=> $trans]);
    }

    public function confirmPaymentTransaction(Request $request)
    {
        $trans = DB::table('payment_transactions')->find($request->id);

        if($trans->code == 'DEPOSIT') {

            $wallet = DB::table('wallets')
                            ->where('user_id', $trans->user_id)
                            ->where('is_default', 'Y')
                            ->where('status', 'CO')
                            ->first();

            $wallet_amount = $wallet->amount + $trans->amount;

            DB::table('wallets')->where('id', $wallet->id)->update(['amount' => $wallet_amount]);
            DB::table('payment_transactions')->where('id', $request->id)->update(['status' => 'CO', 'updated_at' => date('Y-m-d H:i:s')]);
            
            $c_bank_account = DB::table('c_bank_accounts')
                                ->where('id', $trans->c_bank_account_id)
                                ->where('is_active', 'N')
                                ->update([
                                    'is_active' => 'Y',
                                    'status' => 'CO'
                                ]);

        }else if($trans->code == 'WITHDRAW') {
            DB::table('payment_transactions')
                    ->where('id', $request->id)
                    ->update([
                        'status' => 'CO', 
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
        }

        PaymentTransactionLog::where('payment_transaction_id', $request->id)
                                    ->update(['status' => 'CO', 'staff_id' => Auth::user()->id]);

        return redirect()->back();
    }

    public function voidPaymentTransaction(Request $request)
    {
        DB::table('payment_transactions')
                ->where('id', $request->id)
                ->update([
                    'status' => 'VO'
                ]);

        PaymentTransactionLog::where('payment_transaction_id', $request->id)
                                ->update(['status' => 'VO', 'staff_id' => Auth::user()->id]);

        return redirect()->back();
    }


    public function getPaymentTransactionByUserId($id)
    {
        return DB::table('payment_transactions')
                ->leftJoin('users', 'payment_transactions.user_id', '=', 'users.id')
                ->leftJoin('staffs as admin', 'payment_transactions.staff_id', '=', 'admin.id')
                ->leftJoin('c_bank_accounts', 'payment_transactions.c_bank_account_id', '=', 'c_bank_accounts.id')
                ->leftJoin('banks', 'payment_transactions.from_bank_id', '=', 'banks.id')
                ->leftJoin('user_bankings', 'payment_transactions.user_banking_id', '=', 'user_bankings.id')
                ->leftJoin('wallets as from_wallet', 'payment_transactions.from_wallet_id', '=', 'from_wallet.id')
                ->leftJoin('wallets as to_wallet', 'payment_transactions.to_wallet_id', '=', 'to_wallet.id')
                ->leftJoin('banks as ubank', 'user_bankings.bank_id', '=', 'ubank.id')
                ->leftJoin('banks as cbank', 'c_bank_accounts.bank_id', '=', 'cbank.id')
                ->leftJoin('games as from_game', 'from_wallet.game_id', '=', 'from_game.id')
                ->leftJoin('games as to_game', 'to_wallet.game_id', '=', 'to_game.id')
                ->where('payment_transactions.user_id', $id)
                ->select('payment_transactions.*', 
                        'users.username', 'users.name', 'users.currency', 'admin.username as by_admin',
                        'c_bank_accounts.bank_id as bank_name', 'c_bank_accounts.account_name', 'c_bank_accounts.account_number',
                        'banks.name as from_bank_nane', 'banks.name_en as from_bank_name_en',
                        'payment_transactions.account_name as from_account_name', 'payment_transactions.account_number as from_account_number',
                        'user_bankings.bank_id as user_bank_name', 'user_bankings.bank_account_name', 'user_bankings.bank_account_number',
                        'from_game.name as from_game', 'to_game.name as to_game',
                        'from_wallet.is_default as from_default', 'to_wallet.is_default as to_default',
                        'ubank.name as ubank_name', 'cbank.name as cbank_name',
                        )
                ->orderBy('payment_transactions.created_at', 'desc')
                ->paginate(20);
    }


    public function insertTransactionByAdmin($amount, $reason, $type, $user_id, $to_wallet)
    {
        $trans = DB::table('payment_transactions')
                ->insert([
                    'user_id' => $user_id,
                    'staff_id' => Auth::user()->id,
                    'to_wallet_id' => $to_wallet,
                    'action_date' => date('Y-m-d H:i:s'),
                    'code' => 'ADJUST',
                    'amount' => $amount,
                    'status' => 'CO',
                    'description' => $reason,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

        $transId = DB::getPdo()->lastInsertId();

        if($trans) {
            PaymentTransactionLog::create([
                'payment_transaction_id' => $transId,
                'user_id' => $user_id,
                'staff_id' => Auth::user()->id,
                'to_wallet_id' => $to_wallet,
                'code' => 'ADJUST',
                'amount' => $amount,
                'status' => 'CO',
                'description' => $type
            ]);

            return $trans;
        }
    }
}
