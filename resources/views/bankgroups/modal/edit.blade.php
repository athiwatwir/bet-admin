<!-- Bank Edit Modal -->
<div class="modal fade" id="bankGroupEditModal" tabindex="-1" role="dialog" aria-labelledby="bankGroupEditModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-50" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/settings/bank-groups/edit') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขกลุ่มธนาคาร</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อกลุ่มธนาคาร') }}</label>

                        <div class="col-md-6">
                            <input placeholder="ชื่อกลุ่มธนาคาร" id="bankgroup_name" type="text" class="form-control" name="name" value="{{ old('name') }}" autocomplete="name">
                        </div>
                    </div>

                    <div id="is-not-active" class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('สถานะ') }}</label>

                        <div class="col-md-6" style="display: inline-flex; align-items: center;">
                            <input type="checkbox" class="form-control mr-2" id="bankgroup_isactive" name="isactive" style="width: 20px;">
                            <label for="bankgroup_isactive" class="mb-0">เปิดใช้งาน</label>
                        </div>
                    </div>

                    <div id="is-not-default" class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{ __('ค่าเริ่มต้น') }}</label>

                        <div class="col-md-6" style="display: inline-flex; align-items: center;">
                            <input type="checkbox" class="form-control mr-2" id="bankgroup_isdefault" name="isdefault" style="width: 20px;">
                            <label for="bankgroup_isdefault" class="mb-0">ตั้งเป็นกลุ่มเริ่มต้น</label>
                        </div>
                    </div>

                    <input type="hidden" id="bankgroup_id" name="id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">แก้ไขกลุ่มธนาคาร</button>
                </div>
            </form>
        </div>
    </div>
</div>