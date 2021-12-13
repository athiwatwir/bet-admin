<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\PaymentTransactionLog;
use App\Models\User;

class PaymentTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:transaction']);
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
                    ->get();

        return view('transaction.payments', ['transaction'=> $trans, 'type' =>'']);
    }

    public function deposit()
    {
        $deposit = $this->getTransaction('DEPOSIT');
        return view('transaction.payments', ['transaction'=> $deposit, 'type' =>'DEPOSIT']);
    }

    public function transfer()
    {
        $transfer = $this->getTransaction('TRANSFER');
        return view('transaction.payments', ['transaction'=> $transfer, 'type' =>'TRANSFER']);
    }

    public function withdraw()
    {
        $withdraw = $this->getTransaction('WITHDRAW');
        return view('transaction.payments', ['transaction'=> $withdraw, 'type' =>'WITHDRAW']);
    }

    public function adjust()
    {
        $withdraw = $this->getTransaction('ADJUST');
        $users = $this->getUser();
        return view('transaction.payments', ['transaction'=> $withdraw, 'users' => $users, 'type' =>'ADJUST']);
    }

    public function isRequestAdjust()
    {
        return $this->getTransaction('ADJUST');
    }

    private function getTransaction($code)
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
                    ->where('payment_transactions.code', $code)
                    ->select('payment_transactions.*', 
                            'users.id as user_id', 'users.username', 'users.name', 'users.currency', 'admin.username as by_admin',
                            'c_bank_accounts.bank_id as bank_name', 'c_bank_accounts.account_name', 'c_bank_accounts.account_number',
                            'banks.name as from_bank_nane', 'banks.name_en as from_bank_name_en',
                            'payment_transactions.account_name as from_account_name', 'payment_transactions.account_number as from_account_number',
                            'user_bankings.bank_id as user_bank_name', 'user_bankings.bank_account_name', 'user_bankings.bank_account_number',
                            'from_game.name as from_game', 'to_game.name as to_game',
                            'from_wallet.is_default as from_default','to_wallet.is_default as to_default',
                            'ubank.name as ubank_name', 'cbank.name as cbank_name',
                            )
                    ->orderBy('payment_transactions.created_at', 'desc')
                    ->get();

        return $trans;
    }

    private function getUser()
    {
        return DB::table('users')->leftJoin('wallets', 'users.id', '=', 'wallets.user_id')
                    ->where('users.is_active', 'Y')
                    ->where('users.status', 'CO')
                    ->where('wallets.is_default', 'Y')
                    ->select('users.*', 'wallets.id as wallet_id', 'wallets.amount as wallet_amount')
                    ->get();
    }

    public function confirmPaymentTransaction(Request $request)
    {
        $trans = DB::table('payment_transactions')->find($request->id);

        if($trans->code == 'DEPOSIT' && $trans->status == NULL) {

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

            $this->paymentTransactionLogUpdate($request->id);

        }else if($trans->code == 'WITHDRAW' && $trans->status == NULL) {
            DB::table('payment_transactions')
                    ->where('id', $request->id)
                    ->update([
                        'status' => 'CO', 
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

            $this->paymentTransactionLogUpdate($request->id);
        }

        return redirect()->back();
    }

    private function paymentTransactionLogUpdate($id)
    {
        PaymentTransactionLog::where('payment_transaction_id', $id)
                    ->update(['status' => 'CO', 'staff_id' => Auth::user()->id]);
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
                ->get();
    }


    public function insertTransactionByAdmin($amount, $reason, $type, $user_id, $to_wallet)
    {
        $code_status = '';
        if($type == 'เพิ่ม') $code_status = 'Plus';
        if($type == 'ลด') $code_status = 'Minus';

        $transId = Str::uuid();

        $trans = DB::table('payment_transactions')
                ->insert([
                    'id' => $transId,
                    'user_id' => $user_id,
                    'staff_id' => Auth::user()->id,
                    'to_wallet_id' => $to_wallet,
                    'action_date' => date('Y-m-d H:i:s'),
                    'code' => 'ADJUST',
                    'code_status' => $code_status,
                    'amount' => $amount,
                    'status' => 'DR',
                    'description' => $reason,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

        if($trans) {
            PaymentTransactionLog::create([
                'payment_transaction_id' => $transId,
                'user_id' => $user_id,
                'staff_id' => Auth::user()->id,
                'to_wallet_id' => $to_wallet,
                'code' => 'ADJUST',
                'amount' => $amount,
                'status' => 'DR',
                'description' => $type
            ]);

            return $trans;
        }
    }

    public function getPaymentTransactionById($id)
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
                    ->where('payment_transactions.id', $id)
                    ->select('payment_transactions.*', 
                            'users.id as user_id', 'users.username', 'users.name', 'users.currency', 'admin.username as by_admin',
                            'c_bank_accounts.bank_id as bank_name', 'c_bank_accounts.account_name', 'c_bank_accounts.account_number',
                            'banks.name as from_bank_nane', 'banks.name_en as from_bank_name_en',
                            'payment_transactions.account_name as from_account_name', 'payment_transactions.account_number as from_account_number',
                            'user_bankings.bank_id as user_bank_name', 'user_bankings.bank_account_name', 'user_bankings.bank_account_number',
                            'from_game.name as from_game', 'to_game.name as to_game',
                            'from_wallet.is_default as from_default','to_wallet.is_default as to_default',
                            'ubank.name as ubank_name', 'cbank.name as cbank_name',
                            )
                    ->orderBy('payment_transactions.created_at', 'desc')
                    ->get();

        return $trans;
    }
}
