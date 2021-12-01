<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\Pgsoftgame;
use App\Models\User;
use App\Models\UserPgsoftgame;
use App\Models\PlayingTransaction;

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


    // SAVE REPORT TO DB ///////////////////////////////////////////////////////////////////////////////////////////////////

    public function saveToDB() {
        // $results = $this->GetPlayerDailySummary();
        $results = $this->GetPlayerDailySummaryForSpecificTimeRange();
        $games = $this->getPgGame();
        $users = User::get();
        
        foreach($results as $result) {
            PlayingTransaction::updateOrCreate(
                [
                    'user_id' => $this->searchUserName($users, $result['playerName']),
                    'type' => 'pg',
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

    private function GetPlayerDailySummaryForSpecificTimeRange()
    {
        $date_now = date('m/d/Y');
        $millisec = date_create($date_now)->format('U').'000';
        $pgsoft = $this->getPgsoft();
        $response = Http::asForm()->post($pgsoft->datagrab_api_domain.'Bet/v4/GetPlayerDailySummaryForSpecificTimeRange', [
            'operator_token' => $pgsoft->operator_token,
            'secret_key' => $pgsoft->secret_key,
            'count' => 5000,
            'bet_type' => 1,
            'row_version' => $millisec,
            'from_time' => $millisec,
            'to_time' => $millisec
        ]);

        return $response['data'];
        // return response()->json(['data' => $response['data']], 200);
    }

    private function GetPgGame()
    {
        $gameName = '';
        $pgsoft = $this->getPgsoft();
        $response = Http::asForm()->post($pgsoft->pgsoft_api_domain.'Game/v2/Get', [
            'operator_token' => $pgsoft->operator_token,
            'secret_key' => $pgsoft->secret_key,
            'currency' => 'THB'
        ]);

        return $response['data'];
    }

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

    private function getPgsoft()
    {
        return Pgsoftgame::find(1);
    }

    private function GetPlayerDailySummary()
    {
        $pgsoft = $this->getPgsoft();
        $response = Http::asForm()->post($pgsoft->datagrab_api_domain.'Bet/v4/GetPlayerDailySummary', [
            'operator_token' => $pgsoft->operator_token,
            'secret_key' => $pgsoft->secret_key,
            'count' => 5000,
            'bet_type' => 1,
            'row_version' => 1
        ]);

        return $response['data'];
    }


    // END SAVE REPORT TO DB ///////////////////////////////////////////////////////////////////////////////////////////////////
}
