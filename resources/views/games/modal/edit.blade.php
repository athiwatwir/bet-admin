<!-- Bank Edit Modal -->
<div class="modal fade" id="gameEditModal" tabindex="-1" role="dialog" aria-labelledby="gameEditModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 60%;">
        <div class="modal-content">
            <form method="POST" action="{{ url('/games/edit') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขเกม <span id="is_edit_game_name"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="edit_game_name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อเกม') }}</label>

                        <div class="col-md-6">
                            <input required placeholder="ชื่อเกม" id="edit_game_name" type="text" class="form-control @error('edit_game_name') is-invalid @enderror" name="edit_game_name" value="{{ old('edit_game_name') }}" autocomplete="edit_game_name">
                            
                            @error('edit_game_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="edit_game_url" class="col-md-4 col-form-label text-md-right">{{ __('URL') }}</label>

                        <div class="col-md-6">
                            <input required placeholder="URL" id="edit_game_url" type="text" class="form-control @error('edit_game_url') is-invalid @enderror" name="edit_game_url" value="{{ old('edit_game_url') }}" autocomplete="edit_game_url">
                            
                            @error('edit_game_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="edit_game_token" class="col-md-4 col-form-label text-md-right">{{ __('TOKEN') }}</label>

                        <div class="col-md-6">
                            <input required placeholder="TOKEN" id="edit_game_token" type="text" class="form-control @error('edit_game_token') is-invalid @enderror" name="edit_game_token" value="{{ old('edit_game_token') }}" autocomplete="edit_game_token">
                            
                            @error('edit_game_token')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- <div class="form-group row">
                        <label for="edit_game_group_id" class="col-md-4 col-form-label text-md-right">{{ __('กลุ่มเกม') }}</label>

                        <div class="col-md-6">
                            <select required id="edit_game_group_id" class="form-control @error('edit_game_group_id') is-invalid @enderror bg-light" name="edit_game_group_id" autocomplete="edit_game_group_id" disabled readonly>
                                <option value="" selected disabled>-- เลือกกลุ่มเกม --</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                            
                            @error('edit_game_group_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> -->

                    <input type="hidden" id="edit_game_id" name="edit_game_id" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">แก้ไขเกม</button>
                </div>
            </form>
        </div>
    </div>
</div>