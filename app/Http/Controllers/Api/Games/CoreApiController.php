<?php

namespace App\Http\Controllers\Api\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Api\Games\PgSoftGameController as PgSoft;

class CoreApiController extends Controller
{
    public function checkpoint($gamecode, $action, $amount = null)
    {
        $accessToken = auth()->user()->token();
        switch ($gamecode) {
            case 'PGGAME' :
                $response = $this->pgGameAction($accessToken->user_id, $gamecode, $action, $amount);
                return response()->json(['data' => $response]);
                break;
            case 'CASINOGAME' :
                $response = $this->casinoGameAction($gamecode, $action);
                return response()->json(['data' => $response, 'error' => null]);
                break;
        }
    }

    private function pgGameAction($user_id, $gamecode, $action, $amount) {
        switch ($action) {
            case 'create-player' :
                return (new PgSoft)->createPlayer($user_id, $gamecode);
                break;
            case 'login-to-game' :
                return (new PgSoft)->loginToGame($user_id, $gamecode);
                break;
            case 'transfer-in' :
                return (new PgSoft)->transferIn($user_id, $gamecode, $amount);
                break;
            case 'transfer-out' :
                return (new PgSoft)->transferOut($user_id, $gamecode, $amount);
                break;
            case 'get-balance' :
                return (new PgSoft)->getBalance($user_id, $gamecode);
                break;
        }
    }

    private function casinoGameAction($gamecode, $action) {
        switch ($action) {
            case 'login-to-game' :
                return 'data casino game response get login';
                break;
            case 'get-balance' :
                return 'data casino game response get balance';
                break;
            case 'get-profile' :
                return 'data casino game response get profile';
                break;
        }
    }
}
