<!-- Admin Register Modal -->
<div class="modal fade" id="createUserLevel" tabindex="-1" role="dialog" aria-labelledby="createUserLevel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-50" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/user-levels/create') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">สร้างเลเวลผู้ใช้งาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="levelname" class="col-md-4 col-form-label text-md-right">{{ __('เลเวล') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="ชื่อเลเวล" id="levelname" type="text" class="form-control" name="levelname" value="{{ old('levelname') }}" required autocomplete="levelname">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="limit_deposit" class="col-md-4 col-form-label text-md-right">{{ __('ยอดฝากได้สูงสุด') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="ตัวเลขเท่านั้น" id="limit_deposit" type="number" class="form-control" name="limit_deposit" value="{{ old('limit_deposit') }}" required autocomplete="limit_deposit">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="limit_withdraw" class="col-md-4 col-form-label text-md-right">{{ __('ยอดถอนได้สูงสุด') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="ตัวเลขเท่านั้น" id="limit_withdraw" type="number" class="form-control" name="limit_withdraw" value="{{ old('limit_withdraw') }}" required autocomplete="limit_withdraw">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="limit_transfer" class="col-md-4 col-form-label text-md-right">{{ __('ยอดโอนได้สูงสุด') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="ตัวเลขเท่านั้น" id="limit_transfer" type="number" class="form-control" name="limit_transfer" value="{{ old('limit_transfer') }}" required autocomplete="limit_transfer">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-4">
                            <label class="checkbox-inline"><input type="checkbox" name="is_default" value="default" class="ml-2"> ตั้งเป็นค่าเริ่มต้น</label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>