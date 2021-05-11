<!-- Admin Edit Modal -->
<div class="modal fade" id="adminEditModal" tabindex="-1" role="dialog" aria-labelledby="adminEditModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/admins/edit') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไข Admin <span id="admin_username"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="edit_username" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อผู้ใช้') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="Username" id="edit_username" type="text" class="form-control @error('edit_username') is-invalid @enderror" name="edit_username" value="{{ old('edit_username') }}" required autocomplete="edit_username" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="edit_name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อ - สกุล') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input id="edit_name" type="text" class="form-control @error('edit_name') is-invalid @enderror" name="edit_name" value="{{ old('edit_name') }}" required autocomplete="edit_name">

                            @error('edit_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row g-0">
                        <label for="edit_phone" class="col-md-4 col-form-label text-md-right">{{ __('เบอร์ติดต่อ') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="ตัวเลขเท่านั้น" id="edit_phone" type="number" class="form-control @error('edit_phone') is-invalid @enderror" name="edit_phone" value="{{ old('edit_phone') }}" required autocomplete="edit_phone">

                            @error('edit_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="edit_line" class="col-md-4 col-form-label text-md-right">{{ __('ไลน์') }}</label>

                        <div class="col-md-6">
                            <input id="edit_line" type="text" class="form-control" name="edit_line" value="{{ old('edit_line') }}" autocomplete="edit_line">
                        </div>
                    </div>

                    <input type="hidden" id="edit_id" name="edit_id" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">แก้ไข</button>
                </div>
            </form>
        </div>
    </div>
</div>