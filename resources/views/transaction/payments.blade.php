@extends('layouts.core')

@section('title', 'รายการเคลื่อนไหวทางการเงิน')

@section('content')
<div class="row gutters-sm">
    <div class="col-12">
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">

                </div>

                @include('transaction.components.menu_top')
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-0 pt-2">

                <div class="row">
                    @if($type == 'ADJUST')
                    <div class="col-md-12 mb-4">
                        <button class="btn btn-sm btn-indigo transition-hover-top" id="_set-adjust-user-btn">ปรับเปลี่ยนยอดเงินสมาชิก</button>
                        <button class="btn btn-sm btn-indigo btn-soft-static transition-hover-top" id="_set-adjust-user-btn-cancle" style="display: none;">ยกเลิก</button>
                    </div>
                    @endif
                    <div class="col-md-12 px-5">
                        @if($type == 'ADJUST')
                        <div class="row" id="_user-transaction-adjust" style="display: none;">
                            <div class="col-md-8 offset-2">
                                @include('transaction.components.adjust')
                            </div>
                        </div>
                        @endif
                        <div class="row" id="_table-transaction-adjust">
                            <div class="col-md-12">
                                <table class="table-datatable table table-bordered table-hover table-striped"
                                    data-lng-empty="ไม่มีข้อมูล..." 
                                    data-lng-page-info="แสดงผลข้อมูลที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ ข้อมูล" 
                                    data-lng-filtered="(filtered from _MAX_ total entries)" 
                                    data-lng-loading="กำลังโหลด..." 
                                    data-lng-processing="กำลังดำเนินการ..." 
                                    data-lng-search="ค้นหาข้อมูล..." 
                                    data-lng-norecords="ไม่มีข้อมูลที่ค้นหา..." 
                                    data-lng-sort-ascending=": activate to sort column ascending" 
                                    data-lng-sort-descending=": activate to sort column descending" 

                                    data-lng-column-visibility="ปิดการแสดงผลคอลัมน์" 
                                    data-lng-csv="CSV" 
                                    data-lng-pdf="PDF" 
                                    data-lng-xls="XLS" 
                                    data-lng-copy="Copy" 
                                    data-lng-print="Print" 
                                    data-lng-all="ทั้งหมด" 

                                    data-main-search="true" 
                                    data-column-search="false" 
                                    data-row-reorder="false" 
                                    data-col-reorder="true" 
                                    data-responsive="true" 
                                    data-header-fixed="true" 
                                    data-select-onclick="false" 
                                    data-enable-paging="true" 
                                    data-enable-col-sorting="false" 
                                    data-autofill="false" 
                                    data-group="false" 
                                    data-items-per-page="50" 

                                    data-lng-export="<i class='fi fi-squared-dots fs--18 line-height-1'></i>" 
                                    dara-export-pdf-disable-mobile="true" 
                                    data-export='["csv", "pdf", "xls"]' 
                                    data-options='["copy", "print"]' 
                                >

                                    <thead>
                                        <tr class="text-muted fs--13">
                                            <th>ประเภทรายการ</th>
                                            <th class="text-center">รายการของ</th>
                                            <th class="text-center" style="width: 150px;">วัน-เวลา</th>
                                            <th class="text-center">ไปยังบัญชี</th>
                                            <th class="text-center">จำนวนเงิน</th>
                                            <th class="text-center">สถานะ</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($transaction as $key => $trans)
                                        <tr class="text-dark 
                                                @if($trans->code == 'DEPOSIT') bg-deposit 
                                                @elseif($trans->code == 'WITHDRAW') bg-withdraw  
                                                @elseif($trans->code == 'TRANSFER') bg-transfer
                                                @elseif($trans->code == 'ADJUST') bg-increase
                                                @endif ">

                                            <td style="line-height: 17px;">
                                                <p class="mb-0">
                                                    @if($trans->code == 'DEPOSIT')
                                                        <span class="badge badge-success font-weight-normal fs--16">
                                                            เติมเงิน
                                                        </span>
                                                    @elseif($trans->code == 'WITHDRAW')
                                                        <span class="badge badge-danger font-weight-normal fs--16">
                                                            ถอนเงิน
                                                        </span>
                                                    @elseif($trans->code == 'TRANSFER')
                                                        <span class="badge badge-warning font-weight-normal fs--16">
                                                            โอนเงินในระบบ
                                                        </span>
                                                    @elseif($trans->code == 'ADJUST')
                                                        @if($trans->code_status == 'Promo')
                                                            <span class="badge badge-pink font-weight-normal fs--16">
                                                                โปรโมชั่น
                                                            </span>
                                                        @else
                                                            <span class="badge badge-primary font-weight-normal fs--16">
                                                                ปรับเปลี่ยน
                                                            </span>
                                                        @endif
                                                    @endif
                                                </p>
                                                @if(isset($trans->description) && $trans->code_status != 'Promo')
                                                    <small><small><span class="text-danger">**</span> {{ $trans->description }}</small></small>
                                                @endif
                                            </td>

                                            <td class="text-center" style="line-height: 16px;">
                                                @if($trans->code_status == 'Promo')
                                                    {{ $trans->description }}
                                                @else
                                                    {{ $trans->username }}<br/>
                                                    <small class="">{{ $trans->name }}</small>
                                                @endif
                                            </td>

                                            <td class="text-center" style="line-height: 15px; font-size: 13px;">
                                                {{ date('d-m-Y', strtotime($trans->action_date)) }}<br/>
                                                <small>{{ date('H:i:s', strtotime($trans->action_date)) }}</small>
                                            </td>

                                            <td class="text-center" style="line-height: 16px;">
                                                @if(isset($trans->by_admin))
                                                    <small>
                                                        <strong>ผู้ดูแลระบบ : {{ $trans->by_admin }}</strong>
                                                    </small><br/>
                                                    <small><i class="fi fi-arrow-down-full text-primary"></i></small></br>
                                                    <small>
                                                        @if($trans->to_default == 'Y')
                                                            กระเป๋าหลัก
                                                        @else
                                                            กระเป๋าเกม : {{ $trans->to_game }}
                                                        @endif
                                                    </small>
                                                @else
                                                    @if($trans->code == 'DEPOSIT')
                                                        {{ $trans->cbank_name }}<br/>
                                                        <small>{{ $trans->account_name }}</small><br/>
                                                        <small>{{ $trans->account_number }}</small>
                                                    @elseif($trans->code == 'WITHDRAW')
                                                        {{ $trans->ubank_name }}<br/>
                                                        <small>{{ $trans->bank_account_name }}</small><br/>
                                                        <small>{{ $trans->bank_account_number }}</small>
                                                    @elseif($trans->code == 'TRANSFER')
                                                        <small>
                                                            @if($trans->from_default == 'Y')
                                                                กระเป๋าหลัก
                                                            @else
                                                                กระเป๋าเกม : {{ $trans->from_game }}
                                                            @endif
                                                        </small><br/>
                                                        <small><i class="fi fi-arrow-down-full text-primary"></i></small></br>
                                                        <small>
                                                            @if($trans->to_default == 'Y')
                                                                กระเป๋าหลัก
                                                            @else
                                                                กระเป๋าเกม : {{ $trans->to_game }}
                                                            @endif
                                                        </small>
                                                    @endif
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <strong class=" @if($trans->code == 'DEPOSIT') text-success 
                                                            @elseif($trans->code == 'WITHDRAW') text-danger 
                                                            @elseif($trans->code == 'TRANSFER') text-warning
                                                            @endif "
                                                >
                                                @if($trans->code == 'ADJUST')
                                                    @if($trans->code_status == 'Plus')
                                                        <span class="text-success">+ {{ number_format($trans->amount) }}</span>
                                                    @elseif($trans->code_status == 'Minus')
                                                        <span class="text-danger">- {{ number_format($trans->amount) }}</span>
                                                    @elseif($trans->code_status == 'Promo')
                                                        <span class="text-indigo">+ {{ number_format($trans->amount) }}</span>
                                                    @else
                                                        <span class="text-dark">{{ number_format($trans->amount) }}</span>
                                                    @endif
                                                @else
                                                    @if(isset($trans->slip))
                                                    <a href="#!" title="ดูสลิปโอนเงิน" class="mr-2"
                                                            data-toggle="modal" data-target="#paymentSlipModal" 
                                                            onClick="setImagePaymentTransactionSlip(
                                                                '{{ $trans->slip }}', '{{ $trans->from_bank_nane }}', '{{ $trans->from_bank_name_en }}', 
                                                                        '{{ $trans->from_account_name }}', '{{ $trans->from_account_number }}', 
                                                                        '{{ $trans->payment_date }}', '{{ $trans->payment_time }}')">
                                                            <i class="fi fi-image"></i>
                                                        </a>
                                                    @endif
                                                    {{ number_format($trans->amount) }}
                                                @endif
                                                </strong>
                                            </td>

                                            <td class="text-center">
                                                @if($trans->status == 'CO') 
                                                    <small class="badge badge-success font-weight-normal">ยืนยันแล้ว</small>
                                                @elseif($trans->status == 'VO')
                                                    <small class="badge badge-danger font-weight-normal">ปฏิเสธแล้ว</small>
                                                @else
                                                    <small class="badge badge-secondary font-weight-normal">รอยืนยัน</small>
                                                @endif
                                                <br/>
                                                <small class="fs--11">{{ $trans->admin_confirm }}</small>
                                            </td>

                                            @if($type == 'DEPOSIT' || $type == 'WITHDRAW')
                                            <td class="text-align-end">

                                                @if($trans->status == NULL)
                                                    <a href="#!" 
                                                        class="js-ajax-confirm btn btn-success btn-sm btn-vv-sm ml-0 mb-2 rounded" 
                                                        data-href="/transaction/confirm-payment-transaction/{{ $trans->id }}"
                                                        data-ajax-confirm-body="<center>
                                                                                    <h4 class='mb-2'>ยืนยันการทำรายการ ? </h4>
                                                                                </center>" 

                                                        data-ajax-confirm-method="GET" 

                                                        data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                                                        data-ajax-confirm-btn-yes-text="ยืนยัน" 
                                                        data-ajax-confirm-btn-yes-icon="fi fi-check" 

                                                        data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                                                        data-ajax-confirm-btn-no-text="ยกเลิก" 
                                                        data-ajax-confirm-btn-no-icon="fi fi-close"
                                                    >
                                                        ยืนยัน
                                                    </a>
                                                    <a href="#!" 
                                                        class="js-ajax-confirm btn btn-danger btn-sm btn-vv-sm ml-0 mb-2 rounded" 
                                                        data-href="/transaction/void-payment-transaction/{{ $trans->id }}"
                                                        data-ajax-confirm-body="<center>
                                                                                    <h4 class='mb-2'>ยืนยันการทำรายการ ? </h4>
                                                                                </center>" 

                                                        data-ajax-confirm-method="GET" 

                                                        data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                                                        data-ajax-confirm-btn-yes-text="ยืนยัน" 
                                                        data-ajax-confirm-btn-yes-icon="fi fi-check" 

                                                        data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                                                        data-ajax-confirm-btn-no-text="ยกเลิก" 
                                                        data-ajax-confirm-btn-no-icon="fi fi-close"
                                                    >
                                                        ปฏิเสธ
                                                    </a>
                                                @endif

                                            </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr class="text-muted fs--13">
                                            <th>ประเภทรายการ</th>
                                            <th class="text-center">รายการของ</th>
                                            <th class="text-center">วัน-เวลา</th>
                                            <th class="text-center">ไปยังบัญชี</th>
                                            <th class="text-center">จำนวนเงิน</th>
                                            <th class="text-center">สถานะ</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</div>
<style>
    .dt-buttons.btn-group.flex-wrap {
        display: none;
    }
</style>

@if($type == 'ADJUST')
    <script>
        document.querySelector('#_set-adjust-user-btn').addEventListener('click', () => {
            document.querySelector('#_set-adjust-user-btn').style.display = 'none'
            document.querySelector('#_table-transaction-adjust').style.display = 'none'
            document.querySelector('#_set-adjust-user-btn-cancle').style.display = 'initial'
            document.querySelector('#_user-transaction-adjust').style.display = 'initial'
        })

        document.querySelector('#_set-adjust-user-btn-cancle').addEventListener('click', () => {
            document.querySelector('#_set-adjust-user-btn').style.display = 'initial'
            document.querySelector('#_table-transaction-adjust').style.display = 'inline-table'
            document.querySelector('#_set-adjust-user-btn-cancle').style.display = 'none'
            document.querySelector('#_user-transaction-adjust').style.display = 'none'
        })
    </script>
@endif

@endsection

@section('modal')
    @include('user.modal.payment_slip')
    @include('user.modal.wallet_increase')
    @include('user.modal.wallet_decrease')
@endsection