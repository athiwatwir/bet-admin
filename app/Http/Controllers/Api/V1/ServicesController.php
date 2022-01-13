<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Helpers\PgSoftGameComponent as PgGameComponent;
use App\Helpers\CoreGameComponent as CoreGame;

use App\Models\User;
use App\Models\Wallet;
use App\Models\UserLog;
use App\Models\UserPlayingPgsoftgame;

class ServicesController extends Controller
{
    public function updateGameWallet()
    {
        $useronline = $this->getUserOnline();
        // return response()->json(['data' => $useronline]);

        if(sizeof($useronline) > 0) {
            foreach($useronline as $user) {
                $balance = (new CoreGame)->checkpoint($user->user_id, $user->gamecode, 'get-balance');
                Wallet::where('user_id', $user->user_id)->where('api_game_id', $user->api_game_id)->update(['amount' => $balance]);
            }
        }
        return response()->json(['data' => []], 200);
    }

    public function updatePgSoftGamePlayerDailySummaryToDB() {
        $results = (new PgGameComponent)->getReportAll();
        $games = (new PgGameComponent)->getGameName();
        $users = User::get();
        
        foreach($results as $result) {
            UserPlayingPgsoftgame::updateOrCreate(
                [
                    'user_id' => $this->searchUserName($users, $result['playerName']),
                    'game_name' => $this->searchGameName($games, $result['gameId']),
                    'row_version' => date('Y-m-d', $result['rowVersion'] / 1000)
                ],
                [
                    'hands' => $result['hands'],
                    'bet_amount' => $result['betAmount'],
                    'win_loss_amount' => $result['winLossAmount'],
                ]
            );
        }

        return response()->json(['data' => 'done!', 'error' => null], 200);
    }




    // Private Function ////////////////////////////////////////////////////////////////////////////

    private function searchUserName($users, $username)
    {
        foreach($users as $user) {
            if($user['username'] == $username) return $user['id'];
        }
        return '1';
    }

    private function searchGameName($games, $game_id)
    {
        foreach($games as $game) {
            if($game['gameId'] == $game_id) return $game['gameName'];
        }
    }

    private function getUserOnline()
    {
        return DB::table('user_logs')
                ->leftJoin('wallets', 'user_logs.user_id', '=', 'wallets.user_id')
                ->leftJoin('api_games', 'wallets.api_game_id', '=', 'api_games.id')
                ->where('wallets.is_default', 'N')
                ->whereRaw('user_logs.updated_at >= now() - interval 5 minute')
                ->select(['user_logs.user_id', 'wallets.api_game_id', 'api_games.gamecode'])
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
