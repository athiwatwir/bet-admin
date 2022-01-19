<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-30" role="document">
        <div class="modal-content py-2 px-4">

            <div class="modal-header text-center d-block py-1">
                <strong>
                    ตั้งค่าการใช้งานเกมของกลุ่มลูกค้า </br>
                    {{ $name }}
                </strong>
            </div>

            <form method="POST" action="{{ route('userlevel-setting-api-game') }}">
            @csrf
                <div class="modal-body">
                    @foreach($games as $key => $game)
                        <div class="row">
                            <div class="col-6 text-center border-bottom border-right py-2 px-4">
                                <strong class="text-dark">{{ $game['name'] }}</strong>
                            </div>
                            <div class="col-6 text-center border-bottom py-2 px-4">
                                <div id="game_check_{{ $key }}">
                                    <label class="form-switch form-switch form-switch-primary mb-0">
                                        <input type="checkbox" id="game_{{ $game['id'] }}" name="api_game_id[]" value="{{ $game['id'] }}" class="js-form-advanced-required-toggler" 
                                                @if($game['isactive']) checked @endif
                                        >
                                        <i data-on="เปิด" data-off="ปิด"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-vv-sm btn-primary">ยืนยัน</button>
                    <input type="hidden" name="userlevel_id" value="{{ $userlevel_id }}" />
                </div>
            </form>
        </div>
    </div>
</div>