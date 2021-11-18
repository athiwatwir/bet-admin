<!-- Bank Create Modal -->
<div class="modal fade" id="bankGroupCreateModal" tabindex="-1" role="dialog" aria-labelledby="bankGroupCreateModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-50" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/settings/bank-groups') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มกลุ่มธนาคาร</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อกลุ่มธนาคาร') }}</label>

                        <div class="col-md-6">
                            <input required placeholder="ชื่อกลุ่มธนาคาร" id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autocomplete="name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">เพิ่มกลุ่มธนาคาร</button>
                </div>
            </form>
        </div>
    </div>
</div>