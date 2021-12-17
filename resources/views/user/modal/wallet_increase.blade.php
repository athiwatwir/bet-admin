<!-- edit CBANK Modal -->
<div class="modal fade" id="increaseWalletModal" tabindex="-1" role="dialog" aria-labelledby="increaseWalletModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-50" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/users/wallet/increase-wallet-amount') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มเงินในกระเป๋า <span id="wallet_game"></span> ของ <span id="username"></span></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-0">
                        <div class="col-md-6 offset-4 mb-0">
                            <small id="limit_deposit" class="text-danger fs--11"></small>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="wallet_amount" class="col-md-4 col-form-label text-md-right">{{ __('จำนวนเงิน') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="กรุณาระบุจำนวนเงินที่ต้องการเพิ่ม" id="wallet_amount" type="number" class="form-control" value="" name="wallet_amount" required onKeyUp="chackWalletIncreaseAmountValue()">
                            <small id="wallet_amount_notice" class="text-primary"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="is_reason" class="col-md-4 col-form-label text-md-right">{{ __('เหตุผล') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="กรุณาระบุเหตุผล" id="is_reason" type="text" class="form-control @error('is_reason') is-invalid @enderror" name="is_reason" value="{{ old('is_reason') }}" required autocomplete="is_reason">
                        </div>
                    </div>

                    <input type="hidden" id="is_wallet">
                    <input type="hidden" name="wallet_id" id="wallet_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" onClick="clearWalletAmount()">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">เพิ่มจำนวนเงิน</button>
                </div>
            </form>
        </div>
    </div>
</div>