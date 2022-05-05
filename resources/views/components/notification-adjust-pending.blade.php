<div>
    @if($notification)
        <span class="red-dot-notification"></span>
    @endif
</div>

<style>
    .red-dot-notification {
        background: #dd0000;
        width: 8px;
        height: 8px;
        position: absolute;
        border-radius: 50%;
        right: 6px;
        margin-top: -3px;
    }
</style>