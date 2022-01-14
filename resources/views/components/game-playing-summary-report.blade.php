<div class="modal fade" id="{{ $gamecode }}" tabindex="-1" role="dialog" aria-labelledby="{{ $gamecode }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-50" role="document">
        <div class="modal-content px-3 pb-3 pt-4">
            <x-game-summary userid="{{ $userid }}" gamecode="{{ $gamecode }}" />
        </div>
    </div>
</div>