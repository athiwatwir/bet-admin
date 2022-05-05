<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\ApiGame;
use App\Models\User;
use App\Models\UserPlayingWmcasino;

class CasinoGameComponent 
{
    public function hello() {
        $game_data = $this->getGameData();
        $response = Http::asForm()->post($this->getGateway($game_data->api_url).'?cmd=Hello&vendorId='.$this->getVendorId($game_data->api_token).'&signature='.$this->getSignature($game_data->api_token));
        
        return $response['result'];
    }

    public function createPlayer($user_id) { // MemberRegister
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);

        $response = Http::asForm()->post($this->getGateway($game_data->api_url).'?cmd=MemberRegister&vendorId='.$this->getVendorId($game_data->api_token).'&signature='.$this->getSignature($game_data->api_token), [
                'user' => $user->username,
                'password' => $user->phone,
                'username' => $user->username,
                'timestamp' => time()
            ]);

        // return $response['result'];
    }

    public function loginToGame($user_id) { // SigninGame
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);

        $response = Http::asForm()->post($this->getGateway($game_data->api_url).'?cmd=SigninGame&vendorId='.$this->getVendorId($game_data->api_token).'&signature='.$this->getSignature($game_data->api_token), [
                'user' => $user->username,
                'password' => $user->phone,
                'lang' => 2,
                'timestamp' => time()
            ]);

        return $response['result'];
    }

    public function logoutFromGame() { // LogoutGame
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);

        $response = Http::asForm()->post($this->getGateway($game_data->api_url).'?cmd=LogoutGame&vendorId='.$this->getVendorId($game_data->api_token).'&signature='.$this->getSignature($game_data->api_token), [
                'user' => $user->username,
                'timestamp' => time()
            ]);
    }

    public function changePassword() { // ChangePassword
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);

        $response = Http::asForm()->post($this->getGateway($game_data->api_url).'?cmd=ChangePassword&vendorId='.$this->getVendorId($game_data->api_token).'&signature='.$this->getSignature($game_data->api_token), [
                'user' => $user->username,
                'newpassword' => $user->phone,
                'timestamp' => time()
            ]);

        return $response['result'];
    }

    public function getBalance($user_id) { // GetBalance
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);

        $response = Http::asForm()->post(
            $this->getGateway($game_data->api_url).'?cmd=GetBalance&vendorId='.$this->getVendorId($game_data->api_token).'&signature='.$this->getSignature($game_data->api_token), [
                'user' => $user->username,
                'timestamp' => time()
            ]);

        return $response['result'];
    }

    public function transferIn($user_id, $amount) { // ChangeBalance Deposit
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);

        $response = Http::asForm()->post($this->getGateway($game_data->api_url).'?cmd=ChangeBalance&vendorId='.$this->getVendorId($game_data->api_token).'&signature='.$this->getSignature($game_data->api_token), [
                'user' => $user->username,
                'money' => $amount,
                'timestamp' => time()
            ]);

        return $response['result'];
    }

    public function transferOut($user_id, $amount) { // ChangeBalance Withdraw
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);

        $response = Http::asForm()->post($this->getGateway($game_data->api_url).'?cmd=ChangeBalance&vendorId='.$this->getVendorId($game_data->api_token).'&signature='.$this->getSignature($game_data->api_token), [
                'user' => $user->username,
                'money' => -$amount,
                'timestamp' => time()
            ]);

        return $response['result'];
    }

    public function getReportToDB($user_id) {
        $date_now = date('Ymd');
        $game_data = $this->getGameData();
        $user = $this->getUserData($user_id);

        $response = Http::asForm()->post($this->getGateway($game_data->api_url).'?cmd=GetDateTimeReport&vendorId='.$this->getVendorId($game_data->api_token).'&signature='.$this->getSignature($game_data->api_token), [
                'user' => $user->username,
                'startTime' => $date_now.'000000',
                'endTime' => $date_now.'235959',
                'timetype' => 1,
                'datatype' => 0,
                'timestamp' => time()
            ]);

        return $response['result'];
    }

    public function getReport($user_id)
    {
        $response = $this->getUserPlayingWmgame($user_id);
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
        $response = $this->getAllUserPlayingWmgame();
        if(sizeof($response) > 0) {
            $results = $this->groupByName($response);
            $by_bet = array_column($results, 'betAmount');
            array_multisort($by_bet, SORT_DESC, $results);
            
            return $results;
        }else{
            return [];
        }
    }


    // PRIVATE FUNCTION /////////////////////////////////////////////////////////////////////////////
    private function getGameData() {
        return ApiGame::where('gamecode', 'WMGAME')
                        ->where('isactive', 'Y')
                        ->with(['api_url', 'api_token'])
                        ->first();
    }

    private function getGateway($api_url) {
        foreach($api_url as $url) {
            if($url['name'] == 'WMAPIDomain') return $url['url'];
        }
    }

    private function getVendorId($api_token) {
        foreach($api_token as $token) {
            if($token['name'] == 'vendorId') return $token['value'];
        }
    }

    private function getSignature($api_token) {
        foreach($api_token as $token) {
            if($token['name'] == 'signature') return $token['value'];
        }
    }

    private function getUserData($user_id) {
        return User::find($user_id);
    }

    private function getUserPlayingWmgame($user_id) {
        return UserPlayingWmcasino::where('user_id', $user_id)->get();
    }

    private function getAllUserPlayingWmgame() {
        return DB::table('user_playing_wmcasinos')
                    ->leftJoin('users', 'user_playing_wmcasinos.user_id', '=', 'users.id')
                    ->select('user_playing_wmcasinos.*', 'users.username')
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