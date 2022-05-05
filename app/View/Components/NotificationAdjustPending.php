<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\PaymentTransaction;

class NotificationAdjustPending extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $notification = false;

    public function __construct()
    {
        $trans = PaymentTransaction::where('code_status', 'Promo')->where('status', 'DR')->first();
        if(isset($trans)) $this->notification = true;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notification-adjust-pending');
    }
}
