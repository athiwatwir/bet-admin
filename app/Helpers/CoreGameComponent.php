<?php

namespace App\Helpers;

use App\Helpers\PgSoftGameComponent as PgGameComponent;

class CoreGameComponent
{
    public function checkpoint($user_id, $gamecode, $action, $amount = null)
    {
        switch ($gamecode) {
            case 'PGGAME' :
                $response = $this->pgGameAction($user_id, $action, $amount);
                return $response;
                break;
            case 'CASINOGAME' :
                $response = $this->casinoGameAction($gamecode, $action);
                return response()->json(['data' => $response]);
                break;
        }
    }

    private function pgGameAction($user_id, $action, $amount) {
        switch ($action) {
            case 'create-player' :
                return (new PgGameComponent)->createPlayer($user_id);
                break;
            case 'delete-player' :
                return (new PgGameComponent)->deletePlayer($user_id);
                break;
            case 'suspend-player' :
                return (new PgGameComponent)->suspendPlayer($user_id);
                break;
            case 'resume-player' :
                return (new PgGameComponent)->resumePlayer($user_id);
                break;
            case 'player-status' :
                return (new PgGameComponent)->checkPlayerStatus($user_id);
                break;
            case 'login-to-game' :
                return (new PgGameComponent)->loginToGame($user_id);
                break;
            case 'transfer-in' :
                return (new PgGameComponent)->transferIn($user_id, $amount);
                break;
            case 'transfer-out' :
                return (new PgGameComponent)->transferOut($user_id, $amount);
                break;
            case 'get-balance' :
                return (new PgGameComponent)->getBalance($user_id);
                break;
            case 'get-report' :
                return (new PgGameComponent)->getReport($user_id);
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