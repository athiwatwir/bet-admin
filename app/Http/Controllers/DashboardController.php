<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
Use \Carbon\Carbon;

use App\Http\Controllers\PaymentTransactionController as PaymentTransaction;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request) 
    {
        $date = Carbon::now();
        $dateArr =  $date->toArray();
        $monthYearStr = sprintf('%s%s',$dateArr['month'],$dateArr['year']);

        $userCount = DB::table('users')->count();

        $newUserCount = DB::table('users')
                            ->whereMonth('created_at', $dateArr['month'])
                            ->whereYear('created_at', $dateArr['year'])
                            ->count();

        $depositAmt = DB::table('payment_transactions')
                            ->select(DB::raw('SUM(amount) as total_amt'),DB::raw("DATE_FORMAT(created_at, '%m%Y') as mmyyyy"))
                            ->where([[DB::raw("DATE_FORMAT(created_at, '%m%Y')"),$monthYearStr],['code','DEPOSIT'],['status','CO']])
                            ->groupBy('mmyyyy')
                            ->first();

        $withdrawAmt = DB::table('payment_transactions')
                            ->select(DB::raw('SUM(amount) as total_amt'),DB::raw("DATE_FORMAT(created_at, '%m%Y') as mmyyyy"))
                            ->where([[DB::raw("DATE_FORMAT(created_at, '%m%Y')"),$monthYearStr],['code','WITHDRAW'],['status','CO']])
                            ->groupBy('mmyyyy')
                            ->first();

        //Log::info((array)$depositAmt);
        $search_date = '';
        $transactions = isset($request->startdate) ? $this->loadPaymentTransactionWithDate($request) : $this->loadPaymentTransaction();
        if($request->startdate) {
            $search_date = ['start' => date('d-m-Y', strtotime($request->startdate)), 'end' => date('d-m-Y', strtotime($request->enddate))];
        }

        $cardInfo = [
            'userTotalAmt'=>$userCount,
            'newUserTotalAmt'=>$newUserCount,
            'depositAmt'=>isset($depositAmt->total_amt)?$depositAmt->total_amt:0,
            'withdrawAmt'=>isset($withdrawAmt->total_amt)?$withdrawAmt->total_amt:0
        ];


        return view('dashboard', ['cardInfo' => $cardInfo, 'transactions' => $transactions, 'search_date' => $search_date]);
    }

    private function loadPaymentTransaction()
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
                ->leftJoin('payment_transaction_logs', 'payment_transactions.id', '=', 'payment_transaction_logs.payment_transaction_id')
                ->leftJoin('staffs as staff', 'payment_transaction_logs.staff_id', '=', 'staff.id')
                ->whereIn('payment_transactions.code', ['DEPOSIT', 'WITHDRAW'])
                ->select('payment_transactions.*', 
                        'staff.username as staff_username', 'staff.name as staff_name',
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
    }

    private function loadPaymentTransactionWithDate($request)
    {
        $start_date = Carbon::parse($request->startdate)->toDateTimeString();
        $end_date = Carbon::parse($request->enddate)->toDateTimeString();

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
                ->leftJoin('payment_transaction_logs', 'payment_transactions.id', '=', 'payment_transaction_logs.payment_transaction_id')
                ->leftJoin('staffs as staff', 'payment_transaction_logs.staff_id', '=', 'staff.id')
                ->whereIn('payment_transactions.code', ['DEPOSIT', 'WITHDRAW'])
                ->whereBetween('payment_transactions.action_date', [$start_date, $end_date])
                ->select('payment_transactions.*', 
                        'staff.username as staff_username', 'staff.name as staff_name',
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
    }
}