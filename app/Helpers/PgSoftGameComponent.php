<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\ApiGame;
use App\Models\User;
use App\Models\UserPgsoftgame;
use App\Models\UserPlayingPgsoftgame;

class PgSoftGameComponent
{
    public function createPlayer($user_id) {
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);
        $response = Http::asForm()->post($this->getPgSoftAPIDomain($game_data->api_url).'Player/v1/Create?trace_id='.Str::uuid(),[
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'player_name' => $user->username,
            'currency' => $user->currency
        ]);

        return $response['data'];
    }

    public function deletePlayer($user_id) {
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);
        $response = Http::asForm()->post($this->getPgSoftAPIDomain($game_data->api_url).'Player/v1/Kick?trace_id='.Str::uuid(),[
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'player_name' => $user->username
        ]);

        return $response['data'];
    }

    public function suspendPlayer($user_id) {
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);
        $response = Http::asForm()->post($this->getPgSoftAPIDomain($game_data->api_url).'Player/v1/Suspend?trace_id='.Str::uuid(),[
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'player_name' => $user->username
        ]);

        return $response['data'];
    }

    public function resumePlayer($user_id) {
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);
        $response = Http::asForm()->post($this->getPgSoftAPIDomain($game_data->api_url).'Player/v1/Reinstate?trace_id='.Str::uuid(),[
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'player_name' => $user->username
        ]);

        return $response['data'];
    }

    public function checkPlayerStatus($user_id) {
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);
        $response = Http::asForm()->post($this->getPgSoftAPIDomain($game_data->api_url).'Player/v1/Check?trace_id='.Str::uuid(),[
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'player_name' => $user->username
        ]);

        $status = $response['data']['status'] == 0 ? 'Inactive' : 
                ($response['data']['status'] == 1 ? 'Active' : 
                ($response['data']['status'] == 3 ? 'Suspended' : NULL));

        return $status;
    }

    public function loginToGame($user_id) {
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);
        $user_pg = $this->getUserOperator($user_id);
        $response = Http::asForm()->post($this->getPgSoftAPIDomain($game_data->api_url).'Login/v1/LoginGame?trace_id='.Str::uuid(),[
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'player_session' => $user_pg->player_session,
            'operator_player_session' => $user_pg->operator_player_session,
            'player_name' => $user->username,
            'currency' => $user->currency
        ]);

        $url = 'https://'.$game_data->url.'/'.$user_pg->operator_player_session;
        return $url;
    }

    public function transferIn($user_id, $amount) {
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);
        $response = Http::asForm()->post($this->getPgSoftAPIDomain($game_data->api_url).'Cash/v3/TransferIn?trace_id='.Str::uuid(),[
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'player_name' => $user->username,
            'amount' => number_format((float)$amount, 2, '.', ''),
            'transfer_reference' => 'tfi_'.date('YmdHis'),
            'currency' => $user->currency
        ]);

        return $response['data'];
    }

    public function transferOut($user_id, $amount) {
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);
        $response = Http::asForm()->post($this->getPgSoftAPIDomain($game_data->api_url).'Cash/v3/TransferOut?trace_id='.Str::uuid(),[
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'player_name' => $user->username,
            'amount' => number_format((float)$amount, 2, '.', ''),
            'transfer_reference' => 'tfo_'.date('YmdHis'),
            'currency' => $user->currency
        ]);

        return $response['data'];
    }

    public function getBalance($user_id) {
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);
        $response = Http::asForm()->post($this->getPgSoftAPIDomain($game_data->api_url).'Cash/v3/GetPlayerWallet?trace_id='.Str::uuid(),[
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'player_name' => $user->username
        ]);

        return $response['data']['totalBalance'];
    }

    public function getReportAll() { 
        $game_data = $this->getGameData();

        $date_now = date('m/d/Y');
        $millisec = date_create($date_now)->format('U').'000';
        $response = Http::asForm()->post($this->getDataGrabAPIDomain($game_data->api_url).'Bet/v4/GetPlayerDailySummaryForSpecificTimeRange', [
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'count' => 5000,
            'bet_type' => 1,
            'row_version' => $millisec,
            'from_time' => $millisec,
            'to_time' => $millisec
        ]);

        return $response['data'];
    }

    public function getReportWithPlayer($user_id) {
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);

        $date_now = date('m/d/Y');
        $millisec = date_create($date_now)->format('U').'000';
        $response = Http::asForm()->post($this->getDataGrabAPIDomain($game_data->api_url).'Bet/v4/GetPlayerHistory', [
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'player_name' => $user->username,
            'bet_type' => 1,
            'start_time' => $millisec,
            'end_time' => $millisec
        ]);

        return $response['data'];
    }

    public function getGameName()
    {
        $game_data = $this->getGameData();
        $response = Http::asForm()->post($this->getPgSoftAPIDomain($game_data->api_url).'Game/v2/Get', [
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'currency' => 'THB'
        ]);

        return $response['data'];
    }

    public function getReport($user_id)
    {
        $response = $this->getUserPlayingPgsoftgame($user_id);
        $players = [];
        $hands = 0;
        $betAmount = 0;
        $winLossAmount = 0;
        foreach($response as $key => $res) {
            $players[$key]['gameName'] = $res->game_name;
            $players[$key]['hands'] = $res->hands;
            $players[$key]['betAmount'] = $res->bet_amount;
            $players[$key]['winLossAmount'] = $res->win_loss_amount;
            $hands += (int)$res->hands;
            $betAmount += (float)$res->bet_amount;
            $winLossAmount += (float)$res->win_loss_amount;
        }

        $results = $this->groupByGame($players);
        $by_hands = array_column($results, 'hands');
        array_multisort($by_hands, SORT_DESC, $results);

        return ['results' => $results, 'hands' => $hands, 'betAmount' => $betAmount, 'winLossAmount' => $winLossAmount];
    }

    public function getUserPlaying()
    {
        $response = $this->getAllUserPlayingPgsoftgame();
        if(sizeof($response) > 0) {
            $results = $this->groupByName($response);
            $by_bet = array_column($results, 'betAmount');
            array_multisort($by_bet, SORT_DESC, $results);
            
            return $results;
        }else{
            return [];
        }
    }





    // PRIVATE FUNCTION //////////////////////////////////////////////////////////////////////

    private function getPgSoftAPIDomain($api_url) {
        foreach($api_url as $url) {
            if($url['name'] == 'PgSoftAPIDomain') return $url['url'];
        }
    }

    private function getDataGrabAPIDomain($api_url) {
        foreach($api_url as $url) {
            if($url['name'] == 'DataGrabAPIDomain') return $url['url'];
        }
    }

    private function getOperatorToken($api_token) {
        foreach($api_token as $token) {
            if($token['name'] == 'operator_token') return $token['value'];
        }
    }

    private function getSecretKey($api_token) {
        foreach($api_token as $token) {
            if($token['name'] == 'secret_key') return $token['value'];
        }
    }

    private function getGameData() {
        return ApiGame::where('gamecode', 'PGGAME')
                        ->where('isactive', 'Y')
                        ->with(['api_url', 'api_token'])
                        ->first();
    }

    private function getUserData($user_id) {
        return User::find($user_id);
    }

    private function getUserOperator($user_id) {
        return UserPgsoftgame::where('user_id', $user_id)->first();
    }

    private function getUserPlayingPgsoftgame($user_id) {
        return UserPlayingPgsoftgame::where('user_id', $user_id)->get();
    }

    private function getAllUserPlayingPgsoftgame() {
        return DB::table('user_playing_pgsoftgames')
                    ->leftJoin('users', 'user_playing_pgsoftgames.user_id', '=', 'users.id')
                    ->select('user_playing_pgsoftgames.*', 'users.username')
                    ->get();
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
        if(!empty($data)) {
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

            return $groupArr;
        }

        return [];
    }

    private function groupByName($data)
    {
        $group = [];
        foreach($data as $value) {
            $group['player'][$value->username][] = $value;
        }

        return $this->setNewGroupByName($group);
    }

    private function setNewGroupByName($data)
    {
        $groupArr = [];
        foreach($data['player'] as $key => $player) {
            $playerName = '';
            $hands = 0;
            $betAmount = 0;
            $winLossAmount = 0;
            foreach($player as $value) {
                $playerName = $value->username;
                $hands += (int)$value->hands;
                $betAmount += (float)$value->bet_amount;
                $winLossAmount += (float)$value->win_loss_amount;
                // if($value['playerName'] == 'nauthiz99') Log::debug($winLossAmount);
            }
            $groupArr[$key]['playerName'] = $playerName;
            $groupArr[$key]['hands'] = $hands;
            $groupArr[$key]['betAmount'] = $betAmount;
            $groupArr[$key]['winLossAmount'] = $winLossAmount;
        }

        return $groupArr;
    }
}
