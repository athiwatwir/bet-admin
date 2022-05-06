<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Log;

use App\Helpers\CoreGameComponent as CoreGame;

class GameSummary extends Component
{
    public $gamecode;
    public $userid;
    public $reports;

    public function __construct($userid, $gamecode)
    {
        $this->gamecode = $gamecode;
        $this->userid = $userid;
        $this->reports = (new CoreGame)->checkpoint($userid, $gamecode, 'get-report');
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
                return view('components.gamesummary.pgsoftgame');
                break;
            case 'WMGAME' :
                return view('components.gamesummary.wmgame');
                break;
        }
    }
}
