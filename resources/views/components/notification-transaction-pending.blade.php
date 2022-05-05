<div>
    @if($notification && $position == 'main')
        <span class="red-dot-main-notification"></span>
    @endif
    @if($deposit && $position == 'deposit')
        <span class="red-dot-deposit-notification"></span>
    @endif
    @if($deposit && $position == 'menu-deposit')
        <span class="red-dot-menu-deposit-notification"></span>
    @endif
    @if($withdraw && $position == 'withdraw')
        <span class="red-dot-withdraw-notification"></span>
    @endif
    @if($withdraw && $position == 'menu-withdraw')
        <span class="red-dot-menu-withdraw-notification"></span>
    @endif
</div>

<style>
    .red-dot-main-notification {
        background: #dd0000;
        width: 8px;
        height: 8px;
        position: absolute;
        border-radius: 50%;
        right: 6px;
    }
    .red-dot-deposit-notification {
        background: #dd0000;
        width: 8px;
        height: 8px;
        position: absolute;
        border-radius: 50%;
        right: 20%;
        margin-top: -5px;
    }
    .red-dot-menu-deposit-notification {
        background: #dd0000;
        border: 1px solid #fff;
        width: 11px;
        height: 11px;
        position: absolute;
        border-radius: 50%;
        margin-left: 72px;
        margin-top: -11px;
    }
    .red-dot-withdraw-notification {
        background: #dd0000;
        width: 8px;
        height: 8px;
        position: absolute;
        border-radius: 50%;
        right: 38%;
        margin-top: -5px;
    }
    .red-dot-menu-withdraw-notification {
        background: #dd0000;
        border: 1px solid #fff;
        width: 11px;
        height: 11px;
        position: absolute;
        border-radius: 50%;
        margin-left: 50px;
        margin-top: -11px;
    }
</style>