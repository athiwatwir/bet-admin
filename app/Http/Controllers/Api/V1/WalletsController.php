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
use App\Models\BankGroup;
use App\Models\ApiGame;

use App\Helpers\CoreGameComponent as CoreGame;

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


    public function userWallets(Request $request)
    {
        $accessToken = auth()->user()->token();
        $wallet = $this->defaultWallet();

        $wallets = Wallet::where('user_id', '=', $accessToken->user_id)
                            ->leftJoin('api_games', 'wallets.api_game_id', '=', 'api_games.id')
                            ->where('wallets.is_default', '=', 'N')
                            ->where('wallets.status', '!=', 'DL')
                            ->select(['wallets.id', 'wallets.api_game_id', 'api_games.name as game_name', 'api_games.gamecode', 'wallets.amount', 'wallets.currency'])
                            ->orderBy('wallets.created_at', 'desc')
                            ->get();

        $bank_list = $this->getUserBankGroupList($accessToken->user_id);

        $user_bank = DB::table('user_bankings')
                        ->join('banks', 'user_bankings.bank_id', '=', 'banks.id')
                        ->where('user_bankings.user_id', '=', $accessToken->user_id)
                        ->where('user_bankings.is_active', '=', 'Y')
                        ->where('user_bankings.status', '=', 'CO')
                        ->select([
                            'user_bankings.id', 'user_bankings.bank_account_number', 'user_bankings.bank_account_name',
                            'banks.name as bank_name'])
                        ->first();

        // Check All DB Got Value
        // Log::debug($wallets);
        
        if(isset($wallet)){
            return response()->json(['wallet' => $wallet, 'wallets' => $wallets, 'banks' => $bank_list, 'user_bank' => $user_bank, 'status' => 200], 200);
        }

        return response()->json(['status' => 404], 404);
    }

    private function getUserBankGroupList($id)
    {
        $user = User::find($id);
        $group = BankGroup::where('id', $user->bank_group_id)->first();
        $bank_groups = [];
        foreach($group->banks as $key => $bank) {
            $bank_name = DB::table('banks')->find($bank->bank_id);
            $bank_groups[$key]['id'] = $bank->id;
            $bank_groups[$key]['account_name'] = $bank->account_name;
            $bank_groups[$key]['account_number'] = $bank->account_number;
            $bank_groups[$key]['bank_name'] = $bank_name->name;
        }

        return $bank_groups;
    }

    public function createWallet(Request $request)
    {
        $accessToken = auth()->user()->token();

        $walletDupplicate = $this->walletDupplicate($accessToken->user_id, $request->api_game_id);
        $isApiGame = $this->checkApiGame($request->api_game_id);
        
        if($isApiGame) {
            if(!$walletDupplicate) {

                $amount = $request->amount == null ? 0 : $request->amount;

                $default_wallet = $this->defaultWallet();

                if($default_wallet->amount >= $amount) {
                    $is_amount = $amount != 0 ? $default_wallet->amount - $amount : $default_wallet->amount;

                    $wallet = Wallet::create([
                        "user_id" => $accessToken->user_id,
                        "api_game_id" => $request->api_game_id,
                        "amount" => $amount,
                        "currency" => $default_wallet->currency,
                        "is_default" => "N",
                        "status" => 'CO',
                    ]);

                    if($amount > 0) {
                        
                        (new CoreGame)->checkpoint($accessToken->user_id, $request->gamecode, 'transfer-in', $amount);

                        $transId = Str::uuid();
                        $trans = DB::table('payment_transactions')
                            ->insert([
                                'id' => $transId,
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

                    return response()->json(['status' => 404, 'error' => 'เกิดข้อผิดพลาด...กรุณาลองใหม่'], 404);

                }else{
                    return response()->json(['status' => 404, 'error' => 'เงินในกระเป๋าหลักไม่เพียงพอ...กรุณาเพิ่มเงิน หรือ โยกย้ายมาจากเกมอื่น'], 404);
                }
            }else{
                return response()->json(['status' => 404, 'error' => 'กระเป๋าเงินเกมส์ไม่อนุญาตให้ซ้ำกัน...กรุณาตรวจสอบ'], 404);
            }
        }else{
            return response()->json(['status' => 404, 'error' => 'เกมที่คุณเลือกไม่มีอยู่...'], 404);
        }
    }

    private function walletDupplicate($user, $api_game_id)
    {
        $wallet = Wallet::where('user_id', $user)->where('api_game_id', $api_game_id)->get();
        return sizeof($wallet) > 0 ? true : false;
    }

    private function checkApiGame($api_game_id) {
        $api_game = ApiGame::find($api_game_id);
        return isset($api_game) ? true : false;
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
        $level = $this->userLevel($accessToken->user_id);

        if($request->amount <= $level->limit_transfer) {
            if($default_wallet->amount >= $request->amount) {
                $default_wallet_amount = $default_wallet->amount - $request->amount;

                $tranIn = (new CoreGame)->checkpoint($accessToken->user_id, $request->gamecode, 'transfer-in', $request->amount);

                if($tranIn != null) {
                    $wallet = Wallet::find($request->wallet_id);

                    $is_amount = $wallet->amount + $request->amount;

                    $wallet->update(['amount' => $is_amount]);

                    $transId = Str::uuid();

                    $trans = DB::table('payment_transactions')
                        ->insert([
                            'id' => $transId,
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
                
                return response()->json(['message' => 'เกิดข้อผิดพลาด...', 'status' => 400], 400);

            }else{
                return response()->json(['status' => 301], 301);
            }
        }else{
            return response()->json(['message' => 'ยอดเงินโอนเกินกว่ายอดสูงสุดที่กำหนดไว้', 'status' => 400], 400);
        }
    }

    public function transferWallet(Request $request)
    {
        $accessToken = auth()->user()->token();
        $from_wallet = Wallet::find($request->id);
        $level = $this->userLevel($accessToken->user_id);

        if($request->amount <= $level->limit_transfer) {
            if($from_wallet->amount >= $request->amount) {
                $from_wallet_amount = $from_wallet->amount - $request->amount;

                // $tranOut = $this->transferOut($request->amount, $accessToken->user_id);
                $tranOut = (new CoreGame)->checkpoint($accessToken->user_id, $request->gamecode, 'transfer-out', $request->amount);

                if($tranOut != null) {
                    $wallet = Wallet::find($request->to);
                    $is_amount = $wallet->amount + $request->amount;
                    $transId = Str::uuid();

                    $trans = DB::table('payment_transactions')
                            ->insert([
                                'id' => $transId,
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

                return response()->json(['message' => 'เกิดข้อผิดพลาด...', 'status' => 400], 400);

            }else{
                return response()->json(['status' => 301], 301);
            }
        }else{
            return response()->json(['message' => 'ยอดเงินโอนเกินกว่ายอดสูงสุดที่กำหนดไว้', 'status' => 400], 400);
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
        $transId = Str::uuid();

        $trans = DB::table('payment_transactions')
                    ->insert([
                        'id' => $transId,
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

    private function userLevel($id)
    {
        $level = DB::table('users')
                    ->leftJoin('user_levels', 'users.user_level_id', '=', 'user_levels.id')
                    ->where('users.id', $id)
                    ->first();
        return $level;
    }

    public function depositWallet(Request $request)
    {
        $accessToken = auth()->user()->token();
        $default_wallet = $this->defaultWallet();
        $level = $this->userLevel($accessToken->user_id);

        if($request->amount <= $level->limit_deposit) {
            $fileName = time().'_'.$request->file('attachment')->getClientOriginalName();
            $request->file('attachment')->move(public_path('/slips'), $fileName);

            $transId = Str::uuid();
            $trans = DB::table('payment_transactions')
                        ->insert([
                            'id' => $transId,
                            'user_id' => $accessToken->user_id,
                            'c_bank_account_id' => $request->c_bank_account_id,
                            'from_bank_id' => $request->bank_id,
                            'account_name' => $request->account_name,
                            'account_number' => $request->account_number,
                            'payment_date' => $request->payment_date,
                            'payment_time' => $request->payment_time,
                            'action_date' => date('Y-m-d H:i:s'),
                            'code' => 'DEPOSIT',
                            'amount' => $request->amount,
                            'slip' => $fileName,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
            
            
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
        }else{
            return response()->json(['message' => 'ยอดฝากเงินเกินกว่ายอดสูงสุดที่กำหนดไว้', 'status' => 400], 400);
        }
    }

    public function withdrawWallet(Request $request)
    {
        $accessToken = auth()->user()->token();
        $default_wallet = $this->defaultWallet();
        $level = $this->userLevel($accessToken->user_id);

        if($request->amount <= $level->limit_withdraw) {
            if($default_wallet->amount >= $request->amount) {
                $is_amount = $default_wallet->amount - $request->amount;

                $transId = Str::uuid();
                $trans = DB::table('payment_transactions')
                        ->insert([
                            'id' => $transId,
                            'user_id' => $accessToken->user_id,
                            'user_banking_id' => $request->user_bank_id,
                            'action_date' => date('Y-m-d H:i:s'),
                            'code' => 'WITHDRAW',
                            'amount' => $request->amount,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);

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
        }else{
            return response()->json(['message' => 'ยอดถอนเงินเกินกว่ายอดสูงสุดที่กำหนดไว้', 'status' => 400], 400);
        }
    }

    public function getUserWallet_v2(Request $request, $game)
    {
        $accessToken = auth()->user()->token();
        $apigameid = $this->getApiGameIdByGameCode($game);
        $wallet = DB::table('wallets')->where('user_id', $accessToken->user_id)->where('api_game_id', $apigameid->id)->get();
        return response()->json(['data' => $wallet[0]->amount], 200);
    }

    private function getApiGameIdByGameCode($gamecode)
    {
        // return DB::table('api_game_id')->where('gamecode', $game)->get();
        return ApiGame::where('gamecode', $gamecode)->first();
    }

    public function getPlayerSummary()
    {
        $accessToken = auth()->user()->token();
        $playing_transaction = DB::table('playing_transactions')
                                ->where('user_id', $accessToken->user_id)
                                ->where('type', 'pg')
                                ->get();

        $players = [];
        $results = [];
        $hands = 0;
        $betAmount = 0;
        $winLossAmount = 0;
        if(sizeof($playing_transaction) > 0) {
            foreach($playing_transaction as $key => $res) {
                $players[$key]['gameName'] = $res->game_name;
                $players[$key]['hands'] = $res->hands;
                $players[$key]['betAmount'] = $res->bet_amount;
                $players[$key]['winLossAmount'] = $res->win_loss_amount;
                $hands += (int)$res->hands;
                $betAmount += (float)$res->bet_amount;
                $winLossAmount += (float)$res->win_loss_amount;
            }

            $results = $this->groupByGame($players);
        }
        // Log::debug($results);

        return response()->json(['results' => $results, 'hands' => $hands, 'betAmount' => $betAmount, 'winLossAmount' => $winLossAmount]);
    }

    private function groupByGame($data)
    {
        $group = [];
        foreach($data as $value) {
            $group['games'][$value['gameName']][] = $value;
        }

        return $this->setNewGroupByGame($group);
    }

    private function setNewGroupByGame($data)
    {
        $groupArr = [];
        foreach($data['games'] as $key => $game) {
            $gameName = '';
            $hands = 0;
            $betAmount = 0;
            $winLossAmount = 0;
            foreach($game as $value) {
                $gameName = $value['gameName'];
                $hands += (int)$value['hands'];
                $betAmount += (float)$value['betAmount'];
                $winLossAmount += (float)$value['winLossAmount'];
            }
            $groupArr[$key]['gameName'] = $gameName;
            $groupArr[$key]['hands'] = $hands;
            $groupArr[$key]['betAmount'] = $betAmount;
            $groupArr[$key]['winLossAmount'] = $winLossAmount;
        }
        // Log::debug($groupArr);
        
        return $groupArr;
    }
}
