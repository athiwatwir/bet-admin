<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserPgsoftgame;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PgSoftGameController extends Controller
{
    public function checkUserLogin()
    {
        // $accessToken = auth()->user()->token();
        // if(isset($accessToken)) return true;
        // return false;
        Log::debug(Auth::check());
    }

    public function getUserData(Request $request, $ops)
    {
        // Log::debug($this->checkUserLogin());
        if(isset($ops)) {
            $pgsoftgame = UserPgsoftgame::with('user')
                    ->where('operator_player_session', $ops)
                    ->first();

            if(isset($pgsoftgame)) {
                return response()->json(['data' => ['user' => $pgsoftgame->user->username, 'currency' => $pgsoftgame->user->currency], 'error' => null], 200);
            }

            return response()->json(['data' => null, 'error' => ['code' => 404, 'message' => 'Invalid request.']], 404);
        }

        return response()->json(['data' => null, 'error' => ['code' => 404, 'message' => 'Invalid request.']], 404);
    }

    public function getUserWallet(Request $request, $user)
    {
        // Log::debug($user);
        $gameToken = $this->getGameToken();
        $response = Http::asForm()->post($gameToken[0]->pgsoft_api_domain.'Cash/v3/GetPlayerWallet?trace_id='.Str::uuid(),[
            'operator_token' => $gameToken[0]->operator_token,
            'secret_key' => $gameToken[0]->secret_key,
            'player_name' => $user
        ]);
        // Log::debug($response);
        return response()->json(['data' => $response['data']['totalBalance']], 200);
    }

    private function getGameToken()
    {
        $game = DB::table('pgsoftgames')->where('id', 1)->select(['operator_token', 'secret_key', 'pgsoft_api_domain'])->get();
        return $game;
    }
}
