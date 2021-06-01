<!-- edit CBANK Modal -->
<div class="modal fade" id="decreaseWalletModal" tabindex="-1" role="dialog" aria-labelledby="decreaseWalletModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-50" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/users/wallet/decrease-wallet-amount') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ลดเงินในกระเป๋า <span id="wallet_game_decrease"></span> ของ <span id="username_decrease"></span></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="wallet_amount" class="col-md-4 col-form-label text-md-right">{{ __('จำนวนเงิน') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="กรุณาระบุจำนวนเงินที่ต้องการลด" id="wallet_amount_decrease" type="number" class="form-control" value="" name="wallet_amount" onKeyUp="chackWalletDecreaseAmountValue()" required>
                            <small id="wallet_amount_notice_min" class="text-primary"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="is_reason" class="col-md-4 col-form-label text-md-right">{{ __('เหตุผล') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="กรุณาระบุเหตุผล" id="is_reason" type="text" class="form-control @error('is_reason') is-invalid @enderror" name="is_reason" value="{{ old('is_reason') }}" required autocomplete="is_reason">
                        </div>
                    </div>

                    <input type="hidden" id="min_wallet">
                    <input type="hidden" name="wallet_id" id="wallet_id_decrease" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" onClick="clearWalletAmount()">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">ลดจำนวนเงิน</button>
                </div>
            </form>
        </div>
    </div>
</div>