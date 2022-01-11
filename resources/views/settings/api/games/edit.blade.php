@extends('layouts.core')

@section('title', 'รายการเกม')

@section('content')
<div class="row gutters-sm">

    <div class="col-12 col-lg-12 col-xl-12">

        <div class="portlet">

            <div class="portlet-body pt-4">
                <section>
                    <div id="api-game-edit">
                        <div style="display: -webkit-box;">
                            <h4>แก้ไข Api เกม</h4> 
                            <a href="{{ route('setting-api-game-index') }}" class="btn btn-vv-sm btn-secondary ml-3 fs--14">< ย้อนกลับ</a>
                        </div>
                        <div id="card-api-domain" class="card border-secondary shadow-sm mb-4">
                            <div class="card-body">
                                <form method="POST" action="{{ route('setting-api-game-update-name') }}" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 text-center align-self-center">
                                            <img src="{{ Request::root() }}/logogames/{{ $game->logo }}" id="simple-edit-logo" class="w-75 mb-3"><br/>
                                            <input type="file" id="edit-game-logo" name="edit_game_logo" class="fs--12 border" style="display:none;"><br/>
                                            <small id="nottice-game-logo" class="text-danger" style="display: none;"><small>ขนาด 120 x 60 px ไฟล์ PNG ไม่เกิน 100 Kb</small></small>
                                        </div>
                                        <div class="col-12 col-lg-8">

                                            <div style="display: flow-root;">
                                                <strong class="text-dark float-left mr-3">รายละเอียดเกม</strong>
                                                <button type="button" id="game-name-cancel-btn" class="btn btn-vv-sm btn-secondary float-right fs--14 mx-1" title="ยกเลิก" style="display: none;"><i class="fas fa-times"></i> ยกเลิก</button>
                                                <button type="submit" id="game-name-save-btn" class="btn btn-vv-sm btn-success float-right fs--14 mx-1" title="บันทึกการแก้ไข" style="display: none;"><i class="fas fa-save"></i> บันทึกการแก้ไข</button>
                                                <button type="button" id="game-name-edit-btn" class="btn btn-vv-sm btn-warning float-right fs--14 mx-1"><i class="fas fa-edit"></i> แก้ไขรายละเอียด</button>
                                            </div>
                                        
                                            @csrf
                                            <div class="form-label-group mb-4 mt-3">
                                                <input placeholder="ชื่อเกม" id="edit-game-name" name="edit_game_name" type="text" class="form-control" value="{{ $game->name }}" disabled required autocomplete="off">
                                                <label>ชื่อเกม</label>
                                            </div>

                                            <div class="form-label-group mb-4">
                                                <input placeholder="รหัสเกม" id="edit-game-code" name="edit_game_code" type="text" class="form-control" value="{{ $game->gamecode }}" disabled required autocomplete="off">
                                                <label>รหัสเกม</label>
                                            </div>

                                            <div class="form-label-group mb-4">
                                                <input placeholder="ลิงค์เกม" id="edit-game-url" name="edit_game_url" type="text" class="form-control" value="{{ $game->url }}" disabled required autocomplete="off">
                                                <label>ลิงค์เกม</label>
                                            </div>

                                            <div class="form-label-group mt-3">
                                                <select placeholder="กลุ่มเกม" id="edit-game-group" name="edit_game_group" class="form-control select-disabled" required disabled>
                                                    @foreach($gamegroups as $gamegroup)
                                                        <option value="{{ $gamegroup->id }}" @if($gamegroup->id == $game->game_group_id) selected @endif>{{ $gamegroup->name }}</option>
                                                    @endforeach
                                                <select>
                                                <label for="group-input">กลุ่มเกม</label>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="game_id" value="{{ $game->id }}">
                                </form>
                            </div>
                        </div>
                        
                        <div id="card-api-domain" class="card border-secondary shadow-sm mb-4">
                            <div class="card-body">
                                @include('settings.api.games.components.list_edit_url')
                            </div>
                        </div>
                        
                        <div id="card-token" class="card border-secondary shadow-sm mb-4">
                            <div class="card-body">
                                @include('settings.api.games.components.list_edit_token')
                            </div>
                        </div>
                        
                    </div>
                </section>
            </div>

        </div>
    
    </div>

</div>

<style>
    div.dataTables_wrapper div.dataTables_filter input {
        display: none;
    }
    .dt-buttons.btn-group.flex-wrap {
        display: none;
    }
    div.dataTables_wrapper div.dataTables_info {
        font-size: 13px;
        display: none;
    }
    select.custom-select.custom-select-sm.form-control.form-control-sm {
        display: none;
    }
    .custom-form-control {
        border: none;
        background: transparent;
    }
    .setting-form-control {
        padding: 0 15px;
        height: 40px;
        width: 100%;
        border-color: #ccc;
        border-top: none;
        border-right: none;
        border-left: none;
        border-radius: 0;
        /* background-color: transparent; */
    }
    .td-list-item {
        padding: 0 5px !important;
    }
    .page-item.disabled .page-link {
        padding: 3px;
        font-size: 12px;
    }
    .page-item.active .page-link {
        padding: 5px 8px;
        font-size: 12px;
    }
    .dataTables_wrapper .row.mb-3 {
        display: none;
    }
    .btn-game-name-edit {
        z-index: 1;
        position: absolute;
        right: 0;
        margin-right: 10px;
    }
    .select-disabled:disabled {
        background: #e9ecef !important;
    }
</style>

<script>
    const GAME_EDIT_BTN = document.querySelector('#game-name-edit-btn')
    const GAME_NAME = document.querySelector('#edit-game-name')
    const GAME_CODE = document.querySelector('#edit-game-code')
    const GAME_URL = document.querySelector('#edit-game-url')
    const GAME_LOGO = document.querySelector('#edit-game-logo')
    const GAME_GROUP = document.querySelector('#edit-game-group')
    const GAME_NAME_SAVE = document.querySelector('#game-name-save-btn')
    const GAME_NAME_CANCEL = document.querySelector('#game-name-cancel-btn')
    let old_game_name = ''
    let old_game_code = ''
    let old_game_url = ''
    let old_game_logo = ''
    let old_game_group = ''

    GAME_EDIT_BTN.addEventListener('click', () => {
        GAME_NAME.removeAttribute('disabled')
        GAME_CODE.removeAttribute('disabled')
        GAME_URL.removeAttribute('disabled')
        GAME_LOGO.removeAttribute('disabled')
        GAME_GROUP.removeAttribute('disabled')
        old_game_name = GAME_NAME.value
        old_game_code = GAME_CODE.value
        old_game_url = GAME_URL.value
        old_game_group = GAME_GROUP.value
        old_game_logo = document.querySelector('#simple-edit-logo').src
        this.setAttributeGameEditBtn('none', 'initial')
        GAME_LOGO.style.display = 'initial'
        document.querySelector('#nottice-game-logo').style.display = 'initial'
    })

    GAME_NAME_CANCEL.addEventListener('click', () => {
        GAME_NAME.setAttribute('disabled', 'true')
        GAME_CODE.setAttribute('disabled', 'true')
        GAME_URL.setAttribute('disabled', 'true')
        GAME_LOGO.setAttribute('disabled', 'true')
        GAME_GROUP.setAttribute('disabled', 'true')
        GAME_NAME.value = old_game_name
        GAME_CODE.value = old_game_code
        GAME_URL.value = old_game_url
        GAME_GROUP.value = old_game_group
        document.querySelector('#simple-edit-logo').src = old_game_logo
        this.setAttributeGameEditBtn('initial', 'none')
        GAME_LOGO.style.display = 'none'
        document.querySelector('#nottice-game-logo').style.display = 'none'
    })

    GAME_CODE.addEventListener('keyup', () => {
        GAME_CODE.value = GAME_CODE.value.replace(/[^A-Za-z]/ig, '').toUpperCase()
    })

    GAME_LOGO.addEventListener('change', () => {
        const [file] = GAME_LOGO.files
        if (file) {
            document.querySelector('#simple-edit-logo').src = URL.createObjectURL(file)
        }
    })

    function setAttributeGameEditBtn(display1, display2) {
        GAME_EDIT_BTN.style.display = display1

        GAME_NAME_SAVE.style.display = display2
        GAME_NAME_CANCEL.style.display = display2
    }
</script>
@endsection