<?php

namespace App\Helpers;

use App\Helpers\PgSoftGameComponent as PgGame;
use App\Helpers\CasinoGameComponent as CasinoGame;

class CoreGameComponent
{
    public function checkpoint($user_id, $gamecode, $action, $amount = null)
    {
        switch ($gamecode) {
            case 'PGGAME' :
                $response = $this->pgGameAction($user_id, $action, $amount);
                return $response;
                break;
            case 'WMGAME' :
                $response = $this->casinoGameAction($user_id, $action, $amount);
                return $response;
                break;
        }
    }

    private function pgGameAction($user_id, $action, $amount) {
        switch ($action) {
            case 'hello' :
                return (new PgGame)->hello();
                break;
            case 'create-player' :
                return (new PgGame)->createPlayer($user_id);
                break;
            case 'delete-player' :
                return (new PgGame)->deletePlayer($user_id);
                break;
            case 'suspend-player' :
                return (new PgGame)->suspendPlayer($user_id);
                break;
            case 'resume-player' :
                return (new PgGame)->resumePlayer($user_id);
                break;
            case 'player-status' :
                return (new PgGame)->checkPlayerStatus($user_id);
                break;
            case 'login-to-game' :
                return (new PgGame)->loginToGame($user_id);
                break;
            case 'transfer-in' :
                return (new PgGame)->transferIn($user_id, $amount);
                break;
            case 'transfer-out' :
                return (new PgGame)->transferOut($user_id, $amount);
                break;
            case 'get-balance' :
                return (new PgGame)->getBalance($user_id);
                break;
            case 'get-report' :
                return (new PgGame)->getReport($user_id);
                break;
            case 'get-player' :
                return (new PgGame)->getUserPlaying();
                break;
        }
    }

    private function casinoGameAction($user_id, $action, $amount) {
        switch ($action) {
            case 'hello' :
                return (new CasinoGame)->hello();
                break;
            case 'create-player' :
                return (new CasinoGame)->createPlayer($user_id);
                break;
            case 'login-to-game' :
                return (new CasinoGame)->loginToGame($user_id);
                break;
            case 'logout-from-game' :
                return (new CasinoGame)->logoutFromGame($user_id);
                break;
            case 'change-password' :
                return (new CasinoGame)->changePassword($user_id);
                break;
            case 'transfer-in' :
                return (new CasinoGame)->transferIn($user_id, $amount);
                break;
            case 'transfer-out' :
                return (new CasinoGame)->transferOut($user_id, $amount);
                break;
            case 'get-balance' :
                return (new CasinoGame)->getBalance($user_id);
                break;
        }
    }
}