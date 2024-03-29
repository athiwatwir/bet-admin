<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Models\Pgsoftgame;
use App\Models\PlayingTransaction;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ApiGameController;

use App\Helpers\CoreGameComponent as CoreGame;
use App\Helpers\PgSoftGameComponent as PgSoft;

class ReportsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public $ReportTypes = [
        'P001'=>'รายการเคลื่อนไหวทางการเงิน'
    ];

    public function index(){
        return view('reports.index', ['reportTypes' => $this->ReportTypes]);
    }

    public function search(Request $request)
    {
        $results = '';
        $report = '';
        if($request->type === 'P001') {
            $report = 'รายการเคลื่อนไหวทางการเงิน';
            $results = $this->transactionData($request->startdate, $request->enddate);
            foreach($results as $key => $result) { 
                if($result->code_status == 'Promo') $results[$key]->user_level = $this->getUserLevel($result->id);
            }
        }

        return view('reports.index', ['reportTypes' => $this->ReportTypes, 'is_report' => $report, 'start' => $request->startdate, 'end' => $request->enddate, 'results' => $results]);
    }

    public function indexGameReport()
    {
        $games = (new ApiGameController)->getAllApiGame();
        return view('reports.index_games', ['games' => $games]);
    }

    public function viewGameReport($gamecode)
    {
        $game = (new ApiGameController)->getApiGameByGamecode($gamecode);
        return view('reports.view_game', ['game' => $game->name, 'gamecode' => $gamecode]);
    }

    private function getUserLevel($payment_transaction_id)
    {
        $user_level = DB::table('payment_transaction_promotions')
                ->leftJoin('user_levels', 'payment_transaction_promotions.user_level_id', '=', 'user_levels.id')
                ->where('payment_transaction_promotions.payment_transaction_id', $payment_transaction_id)
                ->groupBy('payment_transaction_promotions.user_level_id')
                ->select('user_levels.name')
                ->get();

        $is_user_level = '';
        if($user_level[0]->name != NULL) {
            for($i = 0; $i < count($user_level); $i++) {
                if($i == 0) $is_user_level = $user_level[0]->name;
                else $is_user_level .= ', '.$user_level[$i]->name;
            }
            return $is_user_level;
        }

        return $is_user_level = 'สมาชิกทุกคน';
    }

    private function transactionData($start, $end)
    {
        $start_date = Carbon::parse($start)->toDateTimeString();
        $end_date = Carbon::parse($end)->toDateTimeString();

        $trans = DB::table('payment_transactions')
                    ->leftJoin('users', 'payment_transactions.user_id', '=', 'users.id')
                    ->leftJoin('staffs as admin', 'payment_transactions.staff_id', '=', 'admin.id')
                    ->leftJoin('c_bank_accounts', 'payment_transactions.c_bank_account_id', '=', 'c_bank_accounts.id')
                    ->leftJoin('banks', 'payment_transactions.from_bank_id', '=', 'banks.id')
                    ->leftJoin('user_bankings', 'payment_transactions.user_banking_id', '=', 'user_bankings.id')
                    ->leftJoin('wallets as from_wallet', 'payment_transactions.from_wallet_id', '=', 'from_wallet.id')
                    ->leftJoin('wallets as to_wallet', 'payment_transactions.to_wallet_id', '=', 'to_wallet.id')
                    ->leftJoin('banks as ubank', 'user_bankings.bank_id', '=', 'ubank.id')
                    ->leftJoin('banks as cbank', 'c_bank_accounts.bank_id', '=', 'cbank.id')
                    ->leftJoin('api_games as from_game', 'from_wallet.api_game_id', '=', 'from_game.id')
                    ->leftJoin('api_games as to_game', 'to_wallet.api_game_id', '=', 'to_game.id')
                    ->leftJoin('payment_transaction_logs', 'payment_transactions.id', '=', 'payment_transaction_logs.payment_transaction_id')
                    ->leftJoin('staffs as staff', 'payment_transaction_logs.staff_id', '=', 'staff.id')
                    ->whereBetween('payment_transactions.action_date', [$start_date, $end_date])
                    ->select('payment_transactions.*', 
                            'staff.username as staff_username', 'staff.name as staff_name',
                            'users.username', 'users.name', 'users.currency', 'admin.username as by_admin',
                            'c_bank_accounts.bank_id as bank_name', 'c_bank_accounts.account_name', 'c_bank_accounts.account_number',
                            'banks.name as from_bank_nane', 'banks.name_en as from_bank_name_en',
                            'payment_transactions.account_name as from_account_name', 'payment_transactions.account_number as from_account_number',
                            'user_bankings.bank_id as user_bank_name', 'user_bankings.bank_account_name', 'user_bankings.bank_account_number',
                            'from_game.name as from_game', 'to_game.name as to_game',
                            'from_wallet.is_default as from_default','to_wallet.is_default as to_default',
                            'ubank.name as ubank_name', 'cbank.name as cbank_name',
                            )
                    ->orderBy('payment_transactions.created_at', 'asc')
                    ->get();

        // Log::debug($trans);
        return $trans;
    }

// PG Soft Game Report ------------------------------------------------------------------------------
    public function pgsoft()
    {
        // $res = (new PgSoft)->getUserPlaying();
        $res = $this->getPlayingTransaction();
        if(sizeof($res) > 0) {
            $results = $this->groupByName($res);
            $by_bet = array_column($results, 'betAmount');
            array_multisort($by_bet, SORT_DESC, $results);
            return view('reports.index_pgsoft', ['results' => $results]);
        }else{
            return view('reports.index_pgsoft', ['results' =>[]]);
        }
    }

    public function wmgameByPlayer($player) {
        $gamecode = 'WMGAME';
        $user = (new UsersController)->getUserByUsername($player);
        $response = (new CoreGame)->checkpoint($user[0]->id, $gamecode, 'get-report');
        return view('reports.players.wmgame', ['player' => $user[0]->username, 'player_id' => $user[0]->id, 'gamecode' => $gamecode, 'hands' => $response['hands'], 'betAmount' => $response['betAmount'], 'winLossAmount' => $response['winLossAmount']]);
    }

    public function pgsoftByPlayer($player)
    {
        $gamecode = 'PGGAME';
        $user = (new UsersController)->getUserByUsername($player);
        $response = (new CoreGame)->checkpoint($user[0]->id, $gamecode, 'get-report');
        // $response = $this->getPlayingTransaction();
        // $players = [];
        // $player_id = '';
        // $hands = 0;
        // $betAmount = 0;
        // $winLossAmount = 0;
        // foreach($response['results'] as $key => $res) {
        //         $players[$key]['gameName'] = $res->game_name;
        //         $players[$key]['hands'] = $res->hands;
        //         $players[$key]['betAmount'] = $res->bet_amount;
        //         $players[$key]['winLossAmount'] = $res->win_loss_amount;
        //         $player_id = $res->user_id;
        //         $hands += (int)$res->hands;
        //         $betAmount += (float)$res->bet_amount;
        //         $winLossAmount += (float)$res->win_loss_amount;
        // }

        // $results = $this->groupByGame($players);
        // $by_hands = array_column($results, 'hands');
        // array_multisort($by_hands, SORT_DESC, $results);

        return view('reports.players.pgsoftgame', ['player' => $user[0]->username, 'player_id' => $user[0]->id, 'gamecode' => $gamecode, 'hands' => $response['hands'], 'betAmount' => $response['betAmount'], 'winLossAmount' => $response['winLossAmount']]);
    }

    public function searchPgSoft(Request $request)
    {
        $username = $request->input('username');
        $start_date = Carbon::parse($request->startdate)->toDateTimeString();
        $end_date = Carbon::parse($request->enddate)->toDateTimeString();

        $playing_transactions = DB::table('playing_transactions')
                        ->leftJoin('users', 'playing_transactions.user_id', '=', 'users.id')
                        ->when($username, function ($query, $username) {
                            return $query->where('users.username', $username);
                        })
                        ->whereBetween('playing_transactions.row_version', [$start_date, $end_date])
                        ->select('playing_transactions.*', 'users.username')
                        ->get();

        if(sizeof($playing_transactions) > 0) {
            $results = $this->groupByName($playing_transactions);
            $by_bet = array_column($results, 'betAmount');
            array_multisort($by_bet, SORT_DESC, $results);
            return view('reports.index_pgsoft', ['results' => $results, 'start' => $request->startdate, 'end' => $request->enddate, 'user' => $username]);
        }else{
            return view('reports.index_pgsoft', ['results' => [], 'start' => $request->startdate, 'end' => $request->enddate, 'user' => $username]);
        }
    }

    private function getPlayingTransaction()
    {
        $playing_transaction = DB::table('user_playing_pgsoftgames')
                                    ->leftJoin('users', 'user_playing_pgsoftgames.user_id', '=', 'users.id')
                                    ->select('user_playing_pgsoftgames.*', 'users.username')
                                    ->get();
        return $playing_transaction;
    }

    private function groupByName($data)
    {
        $group = [];
        foreach($data as $value) {
            $group['player'][$value->username][] = $value;
        }

        return $this->setNewGroupByName($group);
    }

    private function setNewGroupByName($data)
    {
        $groupArr = [];
        foreach($data['player'] as $key => $player) {
            $playerName = '';
            $hands = 0;
            $betAmount = 0;
            $winLossAmount = 0;
            foreach($player as $value) {
                $playerName = $value->username;
                $hands += (int)$value->hands;
                $betAmount += (float)$value->bet_amount;
                $winLossAmount += (float)$value->win_loss_amount;
                // if($value['playerName'] == 'nauthiz99') Log::debug($winLossAmount);
            }
            $groupArr[$key]['playerName'] = $playerName;
            $groupArr[$key]['hands'] = $hands;
            $groupArr[$key]['betAmount'] = $betAmount;
            $groupArr[$key]['winLossAmount'] = $winLossAmount;
        }

        return $groupArr;
    }

    private function groupByGame($data)
    {
        $group = [];
        foreach($data as $value) {
            $group['games'][$value['gameName']][] = $value;
        }

        return $this->setNewGroupByGame($group);
    }

    private function setNewGroupByGame($data)
    {
        $groupArr = [];
        if(!empty($data)) {
            foreach($data['games'] as $key => $game) {
                $gameName = '';
                $hands = 0;
                $betAmount = 0;
                $winLossAmount = 0;
                foreach($game as $value) {
                    $gameName = $value['gameName'];
                    $hands += (int)$value['hands'];
                    $betAmount += (float)$value['betAmount'];
                    $winLossAmount += (float)$value['winLossAmount'];
                }
                $groupArr[$key]['gameName'] = $gameName;
                $groupArr[$key]['hands'] = $hands;
                $groupArr[$key]['betAmount'] = $betAmount;
                $groupArr[$key]['winLossAmount'] = $winLossAmount;
            }

            return $groupArr;
        }

        return [];
    }
// END PG Soft Game Report ------------------------------------------------------------------------------

// Call Function //////////////////////////////////////////////////////////////////////////////////////////
    public function getPgsoftByPlayerPlaying($player)
    {
        $response = $this->getPlayingTransaction();
        $players = [];
        $hands = 0;
        $betAmount = 0;
        $winLossAmount = 0;
        foreach($response as $key => $res) {
            if($res->username == $player) {
                $players[$key]['gameName'] = $res->game_name;
                $players[$key]['hands'] = $res->hands;
                $players[$key]['betAmount'] = $res->bet_amount;
                $players[$key]['winLossAmount'] = $res->win_loss_amount;
                $hands += (int)$res->hands;
                $betAmount += (float)$res->bet_amount;
                $winLossAmount += (float)$res->win_loss_amount;
            }
        }

        $results = $this->groupByGame($players);
        $by_hands = array_column($results, 'hands');
        array_multisort($by_hands, SORT_DESC, $results);

        return ['results' => $results, 'hands' => $hands, 'betAmount' => $betAmount, 'winLossAmount' => $winLossAmount];
    }
// END Call Function /////////////////////////////////////////////////////////////////////////////////////
}
