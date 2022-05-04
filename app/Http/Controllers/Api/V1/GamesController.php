<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Providers\RouteServiceProvider as Route;
use App\Http\Controllers\Api\Games\CoreApiController as CoreApi;
use App\Http\Controllers\Api\UsersController;

use App\Models\User;
use App\Models\UserLevel;
use App\Models\UserLevelApiGame;
use App\Models\ApiGame;
use App\Models\Maintenance;

class GamesController extends Controller
{
    public function menuGames()
    {
        $groups = DB::table('game_groups')
                    ->where('is_active', 'Y')
                    ->select('id', 'name')
                    ->get();

        foreach($groups as $key => $group) {
            $games = DB::table('api_games')
                        ->where('game_group_id', $group->id)
                        ->where('isactive', 'Y')
                        ->select('id', 'name', 'gamecode', 'logo')
                        ->get();
                        
            $groups[$key]->games = $games;
        }
        // Log::debug($groups);

        return response()->json(['menugames' => $groups], 200);
    }

    public function getUserLevelApiGame() {
        $accessToken = auth()->user()->token();
        $user = User::find($accessToken->user_id);
        $user_level = $this->getGames($user->user_level_id);

        return response()->json(['data' => $user_level], 200);
    }

    private function getGames($userlevel_id)
    {
        $games = [];
        $allGame = ApiGame::withCount('wallet')->with('game_group')->orderBy('wallet_count', 'DESC')->get();
        foreach($allGame as $game) {
            $matched = UserLevelApiGame::where('user_level_id', $userlevel_id)->where('api_game_id', $game->id)->first();
            if(isset($matched)) {
                if($matched->isactive == 'Y') $ishas = ['id' => $game->id, 'name' => $game->name, 'gamecode' => $game->gamecode, 'isactive' => 1];
                else $ishas = ['id' => $game->id, 'name' => $game->name, 'gamecode' => $game->gamecode, 'isactive' => 0];
                array_push($games, $ishas);
            }else{
                $ishasnt = ['id' => $game->id, 'name' => $game->name, 'gamecode' => $game->gamecode, 'isactive' => 0];
                array_push($games, $ishasnt);
            }
        }
        
        return $games;
    }

    public function gameLogin(Request $request, $table)
    {
        $accessToken = auth()->user()->token();
        $db_table = 'user_'.$table;
        $player = DB::table($db_table)
                    ->leftJoin('users', $db_table.'.user_id', '=', 'users.id')
                    ->where($db_table.'.user_id', $accessToken->user_id)
                    ->select([$db_table.'.player_session', $db_table.'.operator_player_session',
                                'users.username', 'users.currency'
                    ])->get();

        $gameToken = $this->getGameToken($table);
        // Log::debug($gameToken[0]->operator_token);

        // น่าจะต้องลองส่งส่วนนี้ไปให้ pg.playszone.com พร้อมๆ กับ accesstoken
        $response = Http::asForm()->post($gameToken[0]->pgsoft_api_domain.'Login/v1/LoginGame?trace_id='.Str::uuid(),[
                        'operator_token' => $gameToken[0]->operator_token,
                        'secret_key' => $gameToken[0]->secret_key,
                        'player_session' => $player[0]->player_session,
                        'operator_player_session' => $player[0]->operator_player_session,
                        'player_name' => $player[0]->username,
                        'currency' => $player[0]->currency
                    ]);

        // Log::debug($response['data']);
        if($response['data']['player_session'] == strtoupper($player[0]->player_session)) {
            return response()->json(['data' => $player[0]->operator_player_session], 200);
        }

        // $response = (new CoreApi)->checkpoint('PGGAME', 'login-to-game');
        // return $response;
    }

    public function checkGameBalance(Request $request)
    {
        $accessToken = auth()->user()->token();
    }

    private function getGameToken($table)
    {
        $game = DB::table($table)->where('id', 1)->select(['operator_token', 'secret_key', 'pgsoft_api_domain'])->get();
        // Log::debug($game[0]->operator_token);
        return $game;
    }

    public function playGame(Request $request, $id)
    {
        $game = ApiGame::find($id, ['maintenance']);
        if($game->maintenance == 'N') {
            $accessToken = auth()->user()->token();
            // $playGame = DB::table('games')->find($id, ['url', 'token']);
            $wallet = DB::table('wallets')->where('api_game_id', $id)->where('user_id', $accessToken->user_id)->first();
            $is_get_game_wallet = isset($wallet) ? true : false;
            return response()->json(['is_wallet' => $is_get_game_wallet, 'maintenance' => false], 200);
        }else if($game->maintenance == 'Y') {
            $mainten = Maintenance::where('api_game_id', $id)->where('status', 'DR')->where('now', true)->first();
            return response()->json(['maintenance' => true, 'startdate' => $mainten->startdate, 'enddate' => $mainten->enddate, 'description' => $mainten->description], 200);
        }
    }

    public function gameDemo(Request $request, $table) {
        $demo = DB::table($table)->find(1, ['operator_token', 'secret_key', 'pgsoft_api_domain']);
        return response()->json(['demo' => $demo], 200);
    }

    public function createGameTk()
    {
        $token = auth()->pgsoftgame()->createToken('PgsoftgameAuthApp')->accessToken;
        return response()->json(['token' => $token], 200);
    }

    public function gameDescription($id) {
        $desc = ApiGame::find($id, ['logo', 'description']);
        return response()->json(['data' => $desc], 200);
    }



    // WM CASINO CALLBACK Temporary
    public function wmCallBackPost(Request $request)
    {
        return response()->json(['data' => 'Hello!!!'], 200);
    }

    public function wmCallBackGet(Request $request)
    {
        return response()->json(['data' => 'Hello!!!'], 200);
    }
    
}
