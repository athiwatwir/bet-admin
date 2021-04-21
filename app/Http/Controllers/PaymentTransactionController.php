<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                    ->join('c_bank_accounts', 'payment_transactions.c_bank_account_id', '=', 'c_bank_accounts.id')
                    ->select('payment_transactions.*', 'users.username', 'c_bank_accounts.bank_name', 'c_bank_accounts.account_name', 'c_bank_accounts.account_number')
                    ->orderBy('payment_transactions.created_at', 'desc')
                    ->get();

        return view('transaction.payments', ['transaction'=> $trans]);
    }

    public function confirmPaymentTransaction(Request $request)
    {
        $trans = DB::table('payment_transactions')->find($request->id);

        DB::table('payment_transactions')
                ->where('id', $request->id)
                ->update([
                    'user_id' => Auth::user()->id,
                    'status' => 'CO'
                ]);
        
        $c_bank_account = DB::table('c_bank_accounts')
                            ->where('id', $trans->c_bank_account_id)
                            ->where('is_active', 'N')
                            ->update([
                                'is_active' => 'Y',
                                'status' => 'CO'
                            ]);

        return redirect()->back();
    }

    public function voidPaymentTransaction(Request $request)
    {
        DB::table('payment_transactions')
                ->where('id', $request->id)
                ->update([
                    'user_id' => Auth::user()->id,
                    'status' => 'VO'
                ]);

        return redirect()->back();
    }
}
