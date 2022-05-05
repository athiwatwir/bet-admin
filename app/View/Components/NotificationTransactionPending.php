<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\PaymentTransaction;

class NotificationTransactionPending extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $notification = false;
    public $deposit = false;
    public $withdraw = false;
    public $position = '';

    public function __construct($position)
    {
        $this->position = $position;
        $deposit = PaymentTransaction::where('code', 'DEPOSIT')->where('status', NULL)->first();
        $withdraw = PaymentTransaction::where('code', 'WITHDRAW')->where('status', NULL)->first();
        if(isset($deposit)) {
            $this->notification = true;
            $this->deposit = true;
        }
        if(isset($withdraw)) {
            $this->notification = true;
            $this->withdraw = true;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notification-transaction-pending');
    }
}
