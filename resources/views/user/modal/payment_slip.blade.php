<!-- payment Slip Modal -->
<div class="modal fade" id="paymentSlipModal" tabindex="-1" role="dialog" aria-labelledby="paymentSlipModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-60" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <small>
                    <p class="mb-0"><strong class="text-dark">ธนาคารที่โอนมา :</strong> <span id="bank_name"></span></p>
                    <p class="mb-0"><strong class="text-dark">ชื่อผู้โอน :</strong> <span id="bank_account_name"></span> <strong class="text-dark">| เลขบัญชี :</strong> <span id="bank_account_number"></p>
                    <p class="mb-0"><strong class="text-dark">วันที่โอน :</strong> <small id="bank_payment_date"></small> <strong class="text-dark">|</strong> <small id="bank_payment_time"></small></p>
                </small>
                <hr/>
                <img id="slip_img" src="" class="w-100">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>