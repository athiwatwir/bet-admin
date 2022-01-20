<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\ApiGameController as ApiGame;
use App\Http\Controllers\GameGroupsController as GameGroup;
use App\Models\UserLevelApiGame;

class UserLevelSettingApiGame extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $id;
    public $name;
    public $games;
    public $userlevel_id;

    public function __construct($id, $name)
    {
        $this->getId($id);
        $this->id = $id;
        $this->name = $name;
    }

    private function getId($id) {
        $this->userlevel_id = explode('_', $id)[1];
        $this->getGames($this->userlevel_id);
    }

    private function getGames2() {
        $this->games =  (new ApiGame)->getAllApiGame();
    }

    private function getGames($userlevel_id)
    {
        $games = [];
        $allGame = (new ApiGame)->getAllApiGame();
        // $group = (new GameGroup)->getGameGroupWithApiGame();
        foreach($allGame as $game) {
            $matched = UserLevelApiGame::where('user_level_id', $userlevel_id)->where('api_game_id', $game->id)->first();
            if(isset($matched)) {
                if($matched->isactive == 'Y') $ishas = ['id' => $game->id, 'name' => $game->name, 'isactive' => 1];
                else $ishas = ['id' => $game->id, 'name' => $game->name, 'isactive' => 0];
                array_push($games, $ishas);
            }else{
                $ishasnt = ['id' => $game->id, 'name' => $game->name, 'isactive' => 0];
                array_push($games, $ishasnt);
            }
        }
        
        $this->games = $games;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user-level-setting-api-game');
    }
}
