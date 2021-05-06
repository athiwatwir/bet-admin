<!-- edit CBANK Modal -->
<div class="modal fade" id="editWalletModal" tabindex="-1" role="dialog" aria-labelledby="editWalletModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/users/wallet/edit-wallet-amount') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขเงินในกระเป๋า <span id="wallet_game"></span></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="wallet_amount" class="col-md-4 col-form-label text-md-right">{{ __('จำนวนเงิน') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input id="wallet_amount" type="text" class="form-control @error('wallet_amount') is-invalid @enderror" name="wallet_amount" value="{{ old('wallet_amount') }}" required autocomplete="wallet_amount">

                            @error('wallet_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="wallet_id" id="wallet_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">แก้ไข</button>
                </div>
            </form>
        </div>
    </div>
</div>