<a	href="#!" 
    class="js-ajax-confirm btn btn-vv-sm btn-success mr-2 fs--14" 
    data-href="{{ route('adjust-confirm', ['id' => $trans->id]) }}"
    data-ajax-confirm-body="<center>
                                <h4 class='mb-2'>ยืนยันการปรับเปลี่ยนยอดเงิน ? </h4>
                                สมาชิก : {{ $trans->username }} | 
                                จำนวนเงิน @if($trans->code_status == 'Plus')
                                    <span class='text-success'>+ {{ number_format($trans->amount) }}</span>
                                @elseif($trans->code_status == 'Minus')
                                    <span class='text-danger'>- {{ number_format($trans->amount) }}</span>
                                @endif
                            </center>" 

    data-ajax-confirm-method="GET" 

    data-ajax-confirm-btn-yes-class="btn-sm btn-primary" 
    data-ajax-confirm-btn-yes-text="ยืนยัน" 
    data-ajax-confirm-btn-yes-icon="fi fi-check" 

    data-ajax-confirm-btn-no-class="btn-sm btn-light" 
    data-ajax-confirm-btn-no-text="ยกเลิก" 
    data-ajax-confirm-btn-no-icon="fi fi-close">
    ยืนยัน
</a>

<a	href="#!" 
    class="js-ajax-confirm btn btn-vv-sm btn-danger mr-2 fs--14" 
    data-href="{{ route('adjust-void', ['id' => $trans->id]) }}"
    data-ajax-confirm-body="<center>
                                <h4 class='mb-2'>ปฏิเสธการปรับเปลี่ยนยอดเงิน ? </h4>
                                สมาชิก : {{ $trans->username }} | 
                                จำนวนเงิน @if($trans->code_status == 'Plus')
                                    <span class='text-success'>+ {{ number_format($trans->amount) }}</span>
                                @elseif($trans->code_status == 'Minus')
                                    <span class='text-danger'>- {{ number_format($trans->amount) }}</span>
                                @endif
                            </center>" 

    data-ajax-confirm-method="GET" 

    data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
    data-ajax-confirm-btn-yes-text="ยืนยัน" 
    data-ajax-confirm-btn-yes-icon="fi fi-check" 

    data-ajax-confirm-btn-no-class="btn-sm btn-light" 
    data-ajax-confirm-btn-no-text="ยกเลิก" 
    data-ajax-confirm-btn-no-icon="fi fi-close">
    ปฏิเสธ
</a>