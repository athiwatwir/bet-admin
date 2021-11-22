<!-- Admin Register Modal -->
<div class="modal fade" id="editUserLevel" tabindex="-1" role="dialog" aria-labelledby="editUserLevel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-50" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/user-levels/edit') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขเลเวลกลุ่มลูกค้า <span id="modal-header-user-level"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="levelname" class="col-md-4 col-form-label text-md-right">{{ __('เลเวล') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="ชื่อเลเวล" id="levelname_edit" type="text" class="form-control" name="levelname" value="" required autocomplete="levelname">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="limit_deposit" class="col-md-4 col-form-label text-md-right">{{ __('ยอดฝากได้สูงสุด') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="ตัวเลขเท่านั้น" id="limit_deposit_edit" type="number" class="form-control" name="limit_deposit" value="" required autocomplete="limit_deposit">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="limit_withdraw" class="col-md-4 col-form-label text-md-right">{{ __('ยอดถอนได้สูงสุด') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="ตัวเลขเท่านั้น" id="limit_withdraw_edit" type="number" class="form-control" name="limit_withdraw" value="" required autocomplete="limit_withdraw">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="limit_transfer" class="col-md-4 col-form-label text-md-right">{{ __('ยอดโอนได้สูงสุด') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="ตัวเลขเท่านั้น" id="limit_transfer_edit" type="number" class="form-control" name="limit_transfer" value="" required autocomplete="limit_transfer">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-4">
                            <label class="checkbox-inline">
                                <input type="checkbox" id="is_default_edit" name="is_default" value="default" class="ml-2"> <span id="is-user-level-default-label"></span>
                            </label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="userlevel_id" name="id" value="">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>