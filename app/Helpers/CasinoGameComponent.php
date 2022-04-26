<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\ApiGame;
use App\Models\User;

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

    public function getReport($user_id) {
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
}