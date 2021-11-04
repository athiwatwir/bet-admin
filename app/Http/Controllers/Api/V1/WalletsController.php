<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Wallet;
use App\Models\Pgsoftgame;
use App\Models\User;
use App\Models\PaymentTransactionLog;

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

        $walletDupplicate = $this->walletDupplicate($accessToken->user_id, $request->game_id);

        if(!$walletDupplicate) {

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
                    if($request->game_id == 22) { // pgsoftgame game_id = 22
                        $this->transferIn($amount, $accessToken->user_id); //tranfer to pgsoftgame
                    }

                    $trans = DB::table('payment_transactions')
                        ->insert([
                            'user_id' => $accessToken->user_id,
                            'from_wallet_id' => $default_wallet->id,
                            'to_wallet_id' => $wallet->id,
                            'action_date' => date('Y-m-d H:i:s'),
                            'code' => 'TRANSFER',
                            'amount' => $amount,
                            'status' => 'CO',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                    $transId = DB::getPdo()->lastInsertId();

                    if($trans) {
                        PaymentTransactionLog::create([
                            'payment_transaction_id' => $transId,
                            'user_id' => $accessToken->user_id,
                            'from_wallet_id' => $default_wallet->id,
                            'to_wallet_id' => $wallet->id,
                            'code' => 'TRANSFER',
                            'amount' => $amount,
                            'status' => 'CO'
                        ]);
                    }
                }

                if($wallet){
                    Wallet::find($default_wallet->id)->update(['amount' => $is_amount]);

                    return response()->json(['status' => 200], 200);
                }

                return response()->json(['status' => 404], 404);

            }else{
                return response()->json(['status' => 301], 301);
            }
        }else{
            return response()->json(['status' => 404], 404);
        }
    }

    private function walletDupplicate($user, $game)
    {
        $wallet = Wallet::where('user_id', $user)->where('game_id', $game)->get();
        return sizeof($wallet) > 0 ? true : false;
    }

    private function getUserData($id)
    {
        return User::find($id);
    }

    private function getGameData($id)
    {

    }

    public function addWallet(Request $request)
    {
        $accessToken = auth()->user()->token();
        $default_wallet = $this->defaultWallet();

        if($default_wallet->amount >= $request->amount) {
            $default_wallet_amount = $default_wallet->amount - $request->amount;

            $tranIn = $this->transferIn($request->amount, $accessToken->user_id);

            if($tranIn['error'] == null) {
                $wallet = Wallet::find($request->id);

                $is_amount = $wallet->amount + $request->amount;

                $wallet->update(['amount' => $is_amount]);

                $trans = DB::table('payment_transactions')
                    ->insert([
                        'user_id' => $accessToken->user_id,
                        'from_wallet_id' => $default_wallet->id,
                        'to_wallet_id' => $wallet->id,
                        'action_date' => date('Y-m-d H:i:s'),
                        'code' => 'TRANSFER',
                        'amount' => $request->amount,
                        'status' => 'CO',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $transId = DB::getPdo()->lastInsertId();

                if($wallet){
                    Wallet::find($default_wallet->id)->update(['amount' => $default_wallet_amount]);

                    PaymentTransactionLog::create([
                        'payment_transaction_id' => $transId,
                        'user_id' => $accessToken->user_id,
                        'from_wallet_id' => $default_wallet->id,
                        'to_wallet_id' => $wallet->id,
                        'code' => 'TRANSFER',
                        'amount' => $request->amount,
                        'status' => 'CO'
                    ]);

                    return response()->json(['status' => 200], 200);
                }

                return response()->json(['status' => 404], 404);
            }
            
            return response()->json(['message' => $tranIn['error']['message']], 400);

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

            $tranOut = $this->transferOut($request->amount, $accessToken->user_id);

            if($tranOut['error'] == null) {
                $wallet = Wallet::find($request->to);
                $is_amount = $wallet->amount + $request->amount;

                $trans = DB::table('payment_transactions')
                        ->insert([
                            'user_id' => $accessToken->user_id,
                            'from_wallet_id' => $request->id,
                            'to_wallet_id' => $request->to,
                            'action_date' => date('Y-m-d H:i:s'),
                            'code' => 'TRANSFER',
                            'amount' => $request->amount,
                            'status' => 'CO',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                $transId = DB::getPdo()->lastInsertId();

                if($trans) {
                    $wallet->update(['amount' => $is_amount]);

                    PaymentTransactionLog::create([
                        'payment_transaction_id' => $transId,
                        'user_id' => $accessToken->user_id,
                        'from_wallet_id' => $request->id,
                        'to_wallet_id' => $request->to,
                        'code' => 'TRANSFER',
                        'amount' => $request->amount,
                        'status' => 'CO'
                    ]);

                    if($wallet){
                        $from_wallet->update(['amount' => $from_wallet_amount]);

                        return response()->json(['status' => 200], 200);
                    }

                    return response()->json(['status' => 404], 404);
                }
            }

            return response()->json(['message' => $tranOut['error']['message']], 400);

        }else{
            return response()->json(['status' => 301], 301);
        }
    }

    private function transferIn($_amount, $_user_id)
    {
        $pgsoftgame = Pgsoftgame::find(1);
        $user = User::find($_user_id);
        // return response()->json(['data' => $user->username], 200);
        $trace_id = Str::uuid();
        $ref = "ref".date('YmdHis');
        $amount = number_format((float)$_amount, 2, '.', '');

        $response = Http::asForm()->post($pgsoftgame->pgsoft_api_domain.'Cash/v3/TransferIn?trace_id='.$trace_id, [
            'operator_token' => $pgsoftgame->operator_token,
            'secret_key' => $pgsoftgame->secret_key,
            'player_name' => $user->username,
            'amount' => $amount,
            'transfer_reference' => $ref,
            'currency' => $user->currency
        ]);

        // $res = json_decode($response->getBody()->getContents(), true);
        return $response;
    }

    private function transferOut($_amount, $_user_id)
    {
        $pgsoftgame = Pgsoftgame::find(1);
        $user = User::find($_user_id);

        $trace_id = Str::uuid();
        $ref = "ref".date('YmdHis');
        $amount = number_format((float)$_amount, 2, '.', '');

        $response = Http::asForm()->post($pgsoftgame->pgsoft_api_domain.'Cash/v3/TransferOut?trace_id='.$trace_id, [
            'operator_token' => $pgsoftgame->operator_token,
            'secret_key' => $pgsoftgame->secret_key,
            'player_name' => $user->username,
            'amount' => $amount,
            'transfer_reference' => $ref,
            'currency' => $user->currency
        ]);

        // $res = json_decode($response->getBody()->getContents(), true);
        return $response;
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
                        'action_date' => date('Y-m-d H:i:s'),
                        'code' => 'TRANSFER',
                        'amount' => $wallet->amount,
                        'status' => 'CO',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
        $transId = DB::getPdo()->lastInsertId();

        if($trans) {
            $wallet->update(['status' => 'DL', 'amount' => 0]);

            PaymentTransactionLog::create([
                'payment_transaction_id' => $transId,
                'user_id' => $accessToken->user_id,
                'from_wallet_id' => $request->id,
                'to_wallet_id' => $default_wallet->id,
                'code' => 'TRANSFER',
                'amount' => $wallet->amount,
                'status' => 'CO',
                'description' => 'User Delete Wallet.'
            ]);

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
                        'action_date' => date('Y-m-d H:i:s'),
                        'code' => 'DEPOSIT',
                        'amount' => $request->amount,
                        'slip' => $fileName,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
        $transId = DB::getPdo()->lastInsertId();
        
        if($trans) {
            PaymentTransactionLog::create([
                'payment_transaction_id' => $transId,
                'user_id' => $accessToken->user_id,
                'to_wallet_id' => $default_wallet->id,
                'c_bank_account_id' => $request->c_bank_account_id,
                'code' => 'DEPOSIT',
                'amount' => $request->amount
            ]);

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
                        'action_date' => date('Y-m-d H:i:s'),
                        'code' => 'WITHDRAW',
                        'amount' => $request->amount,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

            $transId = DB::getPdo()->lastInsertId();
            if($trans) {
                Wallet::find($default_wallet->id)->update(['amount' => $is_amount]);
                PaymentTransactionLog::create([
                    'payment_transaction_id' => $transId,
                    'user_id' => $accessToken->user_id,
                    'user_banking_id' => $request->user_bank_id,
                    'code' => 'WITHDRAW',
                    'amount' => $request->amount
                ]);
                return response()->json(['status' => 200], 200);
            }
        }else{
            return response()->json(['status' => 301], 301);
        }

        return response()->json(['status' => 401], 401);
    }

    public function getUserWallet_v2(Request $request, $game)
    {
        $accessToken = auth()->user()->token();
        $gameid = $this->getGameId($game);
        $wallet = DB::table('wallets')->where('user_id', $accessToken->user_id)->where('game_id', $gameid[0]->id)->get();
        // Log::debug($wallet);
        return response()->json(['data' => $wallet[0]->amount], 200);
    }

    private function getGameId($game)
    {
        return DB::table('games')->where('name', $game)->get();
    }
}
