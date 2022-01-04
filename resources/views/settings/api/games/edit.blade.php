@extends('layouts.core')

@section('title', 'ตั้งค่า API : เกม')

@section('content')
<div class="row gutters-sm">

    <div class="col-12 col-lg-12 col-xl-12">

        <div class="portlet">

            <div class="portlet-body pt-4">
                <div class="text-right mb-3">
                    <button id="api-game-edit-cancel-btn" class="btn btn-vv-sm btn-secondary" style="display: none;">< กลับ</button>
                </div>
                <section>
                    <div id="api-game-edit">
                        <h4>แก้ไข Api เกม</h4>
                        <div class="form-label-group mb-3">
                            <input placeholder="ชื่อเกม" name="edit[0][game_name]" type="text" class="form-control" value="{{ $game->name }}" disabled>
                            <label>ชื่อเกม</label>
                        </div>
                        <hr/>
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('setting-api-game-update-api-domain') }}">
                                @csrf
                                    @include('settings.api.games.components.list_edit_url')
                                </form>
                            </div>
                        </div>
                        <hr/>
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('setting-api-game-update-token') }}">
                                @csrf
                                    @include('settings.api.games.components.list_edit_token')
                                </form>
                            </div>
                        </div>
                        <hr/>
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('setting-api-game-update-config') }}">
                                @csrf
                                    @include('settings.api.games.components.list_edit_config')
                                </form>
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
</style>
@endsection