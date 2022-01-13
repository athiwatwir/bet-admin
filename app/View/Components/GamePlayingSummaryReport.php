<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Log;

class GamePlayingSummaryReport extends Component
{
    public $gamecode;
    public $userid;

    public function __construct($userid, $gamecode)
    {
        $this->userid = $userid;
        $this->gamecode = $gamecode;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.game-playing-summary-report');
    }
}
