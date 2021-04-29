<!-- Admin Re-Password Modal -->
<div class="modal fade" id="adminRePasswordModal" tabindex="-1" role="dialog" aria-labelledby="adminRePasswordModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/admins/re-password') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไข Admin <span id="admin_username"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="new_password" class="col-md-4 col-form-label text-md-right">{{ __('รหัสผ่านใหม่') }} <span class="text-danger">*</span></label>

                        <div class="col-md-8 d-flex">
                            <input placeholder="Password" id="new_password" type="text" class="form-control @error('new_password') is-invalid @enderror" name="new_password" value="{{ old('new_password') }}" required autocomplete="new_password" readonly>
                            <button type="button" class="btn btn-sm btn-outline-primary ml-2 float-end p-2" title="คัดลอกรหัสผ่าน" onClick="copyNewPassword()">Copy</button>
                        </div>
                    </div>

                    <input type="hidden" id="admin_id" name="admin_id" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">ยืนยัน</button>
                </div>
            </form>
        </div>
    </div>
</div>