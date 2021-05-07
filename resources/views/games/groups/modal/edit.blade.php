<!-- Bank Edit Modal -->
<div class="modal fade" id="groupGameEditModal" tabindex="-1" role="dialog" aria-labelledby="groupGameEditModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/games/groups/edit') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขกลุ่มเกม <span id="game_group_edit"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="edit_game_group_name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อกลุ่มเกม') }}</label>

                        <div class="col-md-6">
                            <input placeholder="ชื่อกลุ่มเกม" id="edit_game_group_name" type="text" class="form-control @error('edit_game_group_name') is-invalid @enderror" name="edit_game_group_name" value="{{ old('edit_game_group_name') }}" autocomplete="edit_game_group_name">
                            
                            @error('edit_game_group_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" id="edit_game_group_id" name="edit_game_group_id" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">แก้ไข</button>
                </div>
            </form>
        </div>
    </div>
</div>