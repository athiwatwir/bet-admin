<?php

namespace App\Http\Controllers\Api\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\ApiGame;
use App\Models\User;
use App\Models\UserPgsoftgame;

class PgSoftGameController extends Controller
{
    public function createPlayer($user_id, $gamecode) {
        $game_data = $this->getGameData($gamecode);
        $user = $this->getUserData($user_id);
        $response = Http::asForm()->post($this->getPgSoftAPIDomain($game_data->api_url).'Player/v1/Create?trace_id='.Str::uuid(),[
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'player_name' => $user->username,
            'currency' => 'THB'
        ]);
    }

    public function loginToGame($user_id, $gamecode) {
        $game_data = $this->getGameData($gamecode);
        $user = $this->getUserData($user_id);
        $response = Http::asForm()->post($this->getPgSoftAPIDomain($game_data->api_url).'Login/v1/LoginGame?trace_id='.Str::uuid(),[
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'player_session' => 'xxxxxxx',
            'operator_player_session' => 'xxxxxxx',
            'player_name' => $user->username,
            'currency' => 'THB'
        ]);
    }

    public function transferIn($user_id, $gamecode, $amount) {
        $game_data = $this->getGameData($gamecode);
        $user = $this->getUserData($user_id);
        $response = Http::asForm()->post($this->getPgSoftAPIDomain($game_data->api_url).'Cash/v3/TransferIn?trace_id='.Str::uuid(),[
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'player_name' => $user->username,
            'amount' => $amount,
            'transfer_reference' => 'tfi_'.date('Y-m-d_H:i:s'),
            'currency' => 'THB'
        ]);
    }

    public function transferOut($user_id, $gamecode, $amount) {
        $game_data = $this->getGameData($gamecode);
        $user = $this->getUserData($user_id);
        $response = Http::asForm()->post($this->getPgSoftAPIDomain($game_data->api_url).'Cash/v3/TransferIn?trace_id='.Str::uuid(),[
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'player_name' => $user->username,
            'amount' => $amount,
            'transfer_reference' => 'tfo_'.date('Y-m-d_H:i:s'),
            'currency' => 'THB'
        ]);
    }

    public function getBalance($user_id, $gamecode) {
        $game_data = $this->getGameData($gamecode);
        $user = $this->getUserData($user_id);
        $response = Http::asForm()->post($this->getPgSoftAPIDomain($game_data->api_url).'Cash/v3/GetPlayerWallet?trace_id='.Str::uuid(),[
            'operator_token' => $this->getOperatorToken($game_data->api_token),
            'secret_key' => $this->getSecretKey($game_data->api_token),
            'player_name' => $user->username
        ]);

        return $response['data']['totalBalance'];
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
}
