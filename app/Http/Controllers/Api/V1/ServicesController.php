<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Models\Wallet;
use App\Models\UserLog;

class ServicesController extends Controller
{
    public function updateGameWallet()
    {
        $useronline = $this->getUserOnline();

        if(sizeof($useronline) > 0) {
            foreach($useronline as $user) {
                $wallet = $this->getUserWallet($user->username);
                Wallet::where('user_id', $user->user_id)->where('game_id', '22')->update(['amount' => $wallet]);
                // return response()->json(['data' => $wallet], 200);
            }
        }
        // return response()->json(['data' => []], 200);
    }

    private function getUserOnline()
    {
        return DB::table('user_logs')
                ->leftJoin('wallets', 'user_logs.user_id', '=', 'wallets.user_id')
                ->leftJoin('users', 'user_logs.user_id', '=', 'users.id')
                ->where('wallets.game_id', '=', '22')
                ->whereRaw('user_logs.updated_at >= now() - interval 5 minute')
                ->select(['user_logs.user_id', 'users.username'])
                ->get();
    }

    private function getUserWallet($user)
    {
        // Log::debug($user);
        $gameToken = $this->getGameToken();
        $response = Http::asForm()->post($gameToken[0]->pgsoft_api_domain.'Cash/v3/GetPlayerWallet?trace_id='.Str::uuid(),[
            'operator_token' => $gameToken[0]->operator_token,
            'secret_key' => $gameToken[0]->secret_key,
            'player_name' => $user
        ]);
        // Log::debug($response);
        return $response['data']['totalBalance'];
    }

    private function getGameToken()
    {
        $game = DB::table('pgsoftgames')->where('id', 1)->select(['operator_token', 'secret_key', 'pgsoft_api_domain'])->get();
        return $game;
    }
}
