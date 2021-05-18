<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletsController extends Controller
{
    private function defaultWallet()
    {
        $accessToken = auth()->user()->token();
        return Wallet::where('user_id', '=', $accessToken->user_id)
                                ->where('is_default', '=', 'Y')
                                ->select(['id', 'amount', 'currency'])
                                ->first();
    }

    private function transaction()
    {

    }


    public function userWallets(Request $request)
    {
        $accessToken = auth()->user()->token();
        $wallet = $this->defaultWallet();

        $wallets = Wallet::where('user_id', '=', $accessToken->user_id)
                            ->leftJoin('games', 'wallets.game_id', '=', 'games.id')
                            ->where('wallets.is_default', '=', 'N')
                            ->where('wallets.status', '!=', 'DL')
                            ->select(['wallets.id', 'games.name as game_name', 'wallets.amount', 'wallets.currency'])
                            ->orderBy('wallets.created_at', 'desc')
                            ->get();

        $c_bank_accounts = DB::table('c_bank_accounts')
                            ->join('banks', 'c_bank_accounts.bank_id', '=', 'banks.id')
                            ->where('c_bank_accounts.is_active', 'Y')
                            ->where('c_bank_accounts.status', 'CO')
                            ->select(['c_bank_accounts.id', 'c_bank_accounts.account_name', 'c_bank_accounts.account_number',
                                        'banks.name as bank_name'])
                            ->get();

        $user_bank = DB::table('user_bankings')
                        ->join('banks', 'user_bankings.bank_id', '=', 'banks.id')
                        ->where('user_bankings.user_id', '=', $accessToken->user_id)
                        ->where('user_bankings.is_active', '=', 'Y')
                        ->where('user_bankings.status', '=', 'CO')
                        ->select([
                            'user_bankings.id', 'user_bankings.bank_account_number', 'user_bankings.bank_account_name',
                            'banks.name as bank_name'])
                        ->first();
        
        if(isset($wallet)){
            return response()->json(['wallet' => $wallet, 'wallets' => $wallets, 'banks' => $c_bank_accounts, 'user_bank' => $user_bank, 'status' => 200], 200);
        }

        return response()->json(['status' => 404], 404);
    }

    public function createWallet(Request $request)
    {
        $accessToken = auth()->user()->token();
        $amount = $request->amount == null ? 0 : $request->amount;

        $default_wallet = $this->defaultWallet();

        if($default_wallet->amount >= $amount) {
            $is_amount = $amount != 0 ? $default_wallet->amount - $amount : $default_wallet->amount;

            $wallet = Wallet::create([
                "user_id" => $accessToken->user_id,
                "game_id" => $request->game_id,
                "amount" => $amount,
                "currency" => $default_wallet->currency,
                "is_default" => "N",
                "status" => 'CO',
            ]);

            if($amount > 0) {
                $trans = DB::table('payment_transactions')
                    ->insert([
                        'user_id' => $accessToken->user_id,
                        'from_wallet_id' => $default_wallet->id,
                        'to_wallet_id' => $wallet->id,
                        'action_date' => date('Y-m-d h:i:s'),
                        'type' => 'ย้าย',
                        'amount' => $amount,
                        'status' => 'CO',
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                    ]);
            }

            if($wallet){
                Wallet::find($default_wallet->id)->update(['amount' => $is_amount]);
                return response()->json(['status' => 200], 200);
            }

            return response()->json(['status' => 404], 404);

        }else{
            return response()->json(['status' => 301], 301);
        }
    }

    public function addWallet(Request $request)
    {
        $accessToken = auth()->user()->token();
        $default_wallet = $this->defaultWallet();

        if($default_wallet->amount >= $request->amount) {
            $default_wallet_amount = $default_wallet->amount - $request->amount;

            $wallet = Wallet::find($request->id);

            $is_amount = $wallet->amount + $request->amount;

            $wallet->update(['amount' => $is_amount]);

            $trans = DB::table('payment_transactions')
                ->insert([
                    'user_id' => $accessToken->user_id,
                    'from_wallet_id' => $default_wallet->id,
                    'to_wallet_id' => $wallet->id,
                    'action_date' => date('Y-m-d h:i:s'),
                    'type' => 'ย้าย',
                    'amount' => $request->amount,
                    'status' => 'CO',
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
            ]);

            if($wallet){
                Wallet::find($default_wallet->id)->update(['amount' => $default_wallet_amount]);
                return response()->json(['status' => 200], 200);
            }

            return response()->json(['status' => 404], 404);

        }else{
            return response()->json(['status' => 301], 301);
        }
    }

    public function transferWallet(Request $request)
    {
        $accessToken = auth()->user()->token();
        $from_wallet = Wallet::find($request->id);

        if($from_wallet->amount >= $request->amount) {
            $from_wallet_amount = $from_wallet->amount - $request->amount;

            $wallet = Wallet::find($request->to);
            $is_amount = $wallet->amount + $request->amount;

            $trans = DB::table('payment_transactions')
                    ->insert([
                        'user_id' => $accessToken->user_id,
                        'from_wallet_id' => $request->id,
                        'to_wallet_id' => $request->to,
                        'action_date' => date('Y-m-d h:i:s'),
                        'type' => 'ย้าย',
                        'amount' => $request->amount,
                        'status' => 'CO',
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                    ]);

            if($trans) {
                $wallet->update(['amount' => $is_amount]);

                if($wallet){
                    $from_wallet->update(['amount' => $from_wallet_amount]);
                    return response()->json(['status' => 200], 200);
                }

                return response()->json(['status' => 404], 404);
            }

        }else{
            return response()->json(['status' => 301], 301);
        }
    }

    public function deleteWallet(Request $request)
    {
        $accessToken = auth()->user()->token();
        $default_wallet = $this->defaultWallet();
        $wallet = Wallet::find($request->id);

        $is_amount = $default_wallet->amount + $wallet->amount;

        $trans = DB::table('payment_transactions')
                    ->insert([
                        'user_id' => $accessToken->user_id,
                        'from_wallet_id' => $request->id,
                        'to_wallet_id' => $default_wallet->id,
                        'action_date' => date('Y-m-d h:i:s'),
                        'type' => 'ย้าย',
                        'amount' => $wallet->amount,
                        'status' => 'CO',
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                    ]);

        if($trans) {
            $wallet->update(['status' => 'DL', 'amount' => 0]);
            Wallet::find($default_wallet->id)->update(['amount' => $is_amount]);
        }

        return response()->json(['status' => 200], 200);
    }

    public function depositWallet(Request $request)
    {
        $accessToken = auth()->user()->token();
        $default_wallet = $this->defaultWallet();

        $fileName = time().'_'.$request->file('attachment')->getClientOriginalName();
        $request->file('attachment')->move(public_path('/slips'), $fileName);

        $trans = DB::table('payment_transactions')
                    ->insert([
                        'user_id' => $accessToken->user_id,
                        'c_bank_account_id' => $request->c_bank_account_id,
                        'action_date' => date('Y-m-d h:i:s'),
                        'type' => 'ฝาก',
                        'amount' => $request->amount,
                        'slip' => $fileName,
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                    ]);
        if($trans) {
            return response()->json(['status' => 200], 200);
        }

        return response()->json(['status' => 401], 401);
    }

    public function withdrawWallet(Request $request)
    {
        $accessToken = auth()->user()->token();
        $default_wallet = $this->defaultWallet();

        if($default_wallet->amount >= $request->amount) {
            $is_amount = $default_wallet->amount - $request->amount;

            $trans = DB::table('payment_transactions')
                    ->insert([
                        'user_id' => $accessToken->user_id,
                        'user_banking_id' => $request->user_bank_id,
                        'action_date' => date('Y-m-d h:i:s'),
                        'type' => 'ถอน',
                        'amount' => $request->amount,
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                    ]);
            if($trans) {
                Wallet::find($default_wallet->id)->update(['amount' => $is_amount]);
                return response()->json(['status' => 200], 200);
            }
        }else{
            return response()->json(['status' => 301], 301);
        }

        return response()->json(['status' => 401], 401);
    }
}
