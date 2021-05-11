<!-- Bank Edit Modal -->
<div class="modal fade" id="bankAddModal" tabindex="-1" role="dialog" aria-labelledby="bankAddModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 50%;">
        <div class="modal-content">
            <form method="POST" action="{{ url('/banks/add') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มธนาคาร</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="bank_name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อธนาคาร') }}</label>

                        <div class="col-md-6">
                            <input placeholder="ชื่อธนาคาร" id="bank_name" type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="{{ old('bank_name') }}" autocomplete="bank_name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="bank_name_en" class="col-md-4 col-form-label text-md-right">{{ __('ภาษาอังกฤษ') }} <small>(ถ้ามี)</small></label>

                        <div class="col-md-6">
                            <input id="bank_name_en" type="text" class="form-control @error('bank_name_en') is-invalid @enderror" name="bank_name_en" value="{{ old('bank_name_en') }}" autocomplete="bank_name_en">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">เพิ่มธนาคาร</button>
                </div>
            </form>
        </div>
    </div>
</div>