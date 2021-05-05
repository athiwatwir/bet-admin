<!-- Bank Edit Modal -->
<div class="modal fade" id="bankEditModal" tabindex="-1" role="dialog" aria-labelledby="bankEditModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/banks/edit') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขธนาคาร</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="edit_bank_name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อธนาคาร') }}</label>

                        <div class="col-md-6">
                            <input placeholder="ชื่อธนาคาร" id="edit_bank_name" type="text" class="form-control @error('edit_bank_name') is-invalid @enderror" name="edit_bank_name" value="{{ old('edit_bank_name') }}" autocomplete="edit_bank_name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="edit_bank_name_en" class="col-md-4 col-form-label text-md-right">{{ __('ภาษาอังกฤษ') }} <small>(ถ้ามี)</small></label>

                        <div class="col-md-6">
                            <input id="edit_bank_name_en" type="text" class="form-control @error('edit_bank_name_en') is-invalid @enderror" name="edit_bank_name_en" value="{{ old('edit_bank_name_en') }}" autocomplete="edit_bank_name_en">
                        </div>
                    </div>

                    <input type="hidden" id="edit_bank_id" name="edit_bank_id" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">แก้ไข</button>
                </div>
            </form>
        </div>
    </div>
</div>