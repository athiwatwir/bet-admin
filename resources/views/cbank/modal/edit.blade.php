<!-- edit CBANK Modal -->
<div class="modal fade" id="editCBankModal" tabindex="-1" role="dialog" aria-labelledby="editCBankModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/edit-cbank') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขธนาคาร</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('ธนาคาร') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <select id="edit_bank" class="form-control @error('edit_bank') is-invalid @enderror" name="edit_bank" required autocomplete="edit_bank">
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->name }} @if($bank->name_en != '')- {{ $bank->name_en }} @endif</option>
                                @endforeach
                            </select>

                            @error('edit_bank')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="edit_account_name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อบัญชี') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input id="edit_account_name" type="text" class="form-control @error('edit_account_name') is-invalid @enderror" name="edit_account_name" value="{{ old('edit_account_name') }}" required autocomplete="edit_account_name">

                            @error('edit_account_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row g-0">
                        <label for="edit_account_number" class="col-md-4 col-form-label text-md-right">{{ __('เลขบัญชี') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="ตัวเลขเท่านั้น" id="edit_account_number" type="number" class="form-control @error('edit_account_number') is-invalid @enderror" name="edit_account_number" value="{{ old('edit_account_number') }}" required autocomplete="edit_account_number">

                            @error('edit_account_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="edit_id" id="edit_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">แก้ไข</button>
                </div>
            </form>
        </div>
    </div>
</div>