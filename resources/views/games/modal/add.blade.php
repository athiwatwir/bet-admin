<!-- Bank Edit Modal -->
<div class="modal fade" id="gameCreateModal" tabindex="-1" role="dialog" aria-labelledby="gameCreateModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-60" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/games/create') }}" enctype="multipart/form-data">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มเกม</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อเกม') }}</label>

                        <div class="col-md-6">
                            <input required placeholder="ชื่อเกม" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name">
                            
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="url" class="col-md-4 col-form-label text-md-right">{{ __('URL') }}</label>

                        <div class="col-md-6">
                            <input required placeholder="URL" id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url') }}" autocomplete="url">
                            
                            @error('url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="token" class="col-md-4 col-form-label text-md-right">{{ __('TOKEN') }}</label>

                        <div class="col-md-6">
                            <input required placeholder="TOKEN" id="token" type="text" class="form-control @error('token') is-invalid @enderror" name="token" value="{{ old('token') }}" autocomplete="token">
                            
                            @error('token')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="game_group_id" class="col-md-4 col-form-label text-md-right">{{ __('กลุ่มเกม') }}</label>

                        <div class="col-md-6">
                            <select required id="game_group_id" class="form-control @error('game_group_id') is-invalid @enderror" name="game_group_id" autocomplete="game_group_id">
                                <option value="" selected disabled>-- เลือกกลุ่มเกม --</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                            
                            @error('game_group_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('โลโก้') }}</label>

                        <div class="col-md-6">
                            <input required id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" value="{{ old('logo') }}" autocomplete="logo">
                            <small class="text-danger"><small>ขนาด 120 x 60 px ไฟล์ PNG ไม่เกิน 100 Kb</small></small>
                            @error('logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">เพิ่มเกม</button>
                </div>
            </form>
        </div>
    </div>
</div>