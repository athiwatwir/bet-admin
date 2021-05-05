<!-- Create CBANK Modal -->
<div class="modal fade" id="createCBankModal" tabindex="-1" role="dialog" aria-labelledby="createCBankModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/create-cbank') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มธนาคาร</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="bank_id" class="col-md-4 col-form-label text-md-right">{{ __('ธนาคาร') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <select id="bank_id" class="form-control @error('bank_name') is-invalid @enderror" name="bank_id" required autocomplete="bank_name">
                                <option value="" selected disabled>-- เลือกธนาคาร --</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->name }} @if($bank->name_en != '')- {{ $bank->name_en }} @endif</option>
                                @endforeach
                            </select>

                            @error('bank_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="account_name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อบัญชี') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input id="account_name" type="text" class="form-control @error('account_name') is-invalid @enderror" name="account_name" value="{{ old('account_name') }}" required autocomplete="account_name">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row g-0">
                        <label for="account_number" class="col-md-4 col-form-label text-md-right">{{ __('เลขบัญชี') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="ตัวเลขเท่านั้น" id="account_number" type="number" class="form-control @error('account_number') is-invalid @enderror" name="account_number" value="{{ old('account_number') }}" required autocomplete="account_number">

                            @error('account_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">เพิ่มบัญชี</button>
                </div>
            </form>
        </div>
    </div>
</div>