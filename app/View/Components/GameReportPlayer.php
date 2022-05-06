<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Log;

use App\Helpers\CoreGameComponent as CoreGame;

class GameReportPlayer extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $players;
    public $gamecode;
    
    public function __construct($gamecode)
    {
        $this->gamecode = $gamecode;
        $this->players = (new CoreGame)->checkpoint(NULL, $gamecode, 'get-player');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        switch ($this->gamecode) {
            case 'PGGAME' :
                return view('components.playerreports.pgsoftgame');
                break;
            case 'WMGAME' :
                return view('components.playerreports.wmgame');
                break;
            }
        }
        
}
