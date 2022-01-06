<?php

namespace App\Http\Controllers\Api\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Api\Games\PgSoftGameController as PgSoft;

class CoreApiController extends Controller
{
    public function checkpoint($gamecode, $action)
    {
        switch ($gamecode) {
            case 'PGGAME' :
                $response = $this->pgGameAction($gamecode, $action);
                return response()->json(['data' => $response, 'error' => null]);
                break;
            case 'CASINOGAME' :
                $response = $this->casinoGameAction($gamecode, $action);
                return response()->json(['data' => $response, 'error' => null]);
                break;
        }
    }

    private function pgGameAction($gamecode, $action) {
        switch ($action) {
            case 'login-to-game' :
                return 'data pg game response get login';
                break;
            case 'get-balance' :
                return (new PgSoft)->getBalance($gamecode);
                break;
            case 'get-profile' :
                return 'data pg game response get profile';
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
