<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public $ReportTypes = [
        'P001'=>'รายการเคลื่อนไหวทางการเงิน'
    ];

    public function index(){

        return view('reports.index', ['reportTypes' => $this->ReportTypes]);
    }

    public function search(Request $request)
    {
        $results = '';
        $report = '';
        if($request->type === 'P001') {
            $report = 'รายการเคลื่อนไหวทางการเงิน';
            $results = $this->transactionData($request->startdate, $request->enddate);
        }

        return view('reports.index', ['reportTypes' => $this->ReportTypes, 'is_report' => $report, 'start' => $request->startdate, 'end' => $request->enddate, 'results' => $results]);
    }

    private function transactionData($start, $end)
    {
        $start_date = Carbon::parse($start)->toDateTimeString();
        $end_date = Carbon::parse($end)->toDateTimeString();

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
                    ->leftJoin('payment_transaction_logs', 'payment_transactions.id', '=', 'payment_transaction_logs.payment_transaction_id')
                    ->leftJoin('staffs as staff', 'payment_transaction_logs.staff_id', '=', 'staff.id')
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
                    ->orderBy('payment_transactions.created_at', 'asc')
                    ->get();

        // Log::debug($trans);
        return $trans;
    }
}
