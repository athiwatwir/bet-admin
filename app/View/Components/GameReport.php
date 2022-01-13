<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Log;

use App\Helpers\CoreGameComponent as CoreGame;

class GameReport extends Component
{
    public $reports;
    public $gamecode;

    public function __construct($userid, $gamecode)
    {
        $this->gamecode = $gamecode;
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
                return 'components.gamereports.pgsoftgame';
                break;
        }
    }
}
