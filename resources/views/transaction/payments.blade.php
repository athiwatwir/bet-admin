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

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    <a href="@if($type == '') #! @else {{ route('transaction-all') }} @endif" class="btn btn-sm btn-primary @if($type == '') @else btn-soft @endif btn-pill mb-1 mr-3 ml-3">รายการทั้งหมด</a>
                    <a href="@if($type == 'DEPOSIT') #! @else {{ route('transaction-deposit') }} @endif" class="btn btn-sm btn-primary @if($type == 'DEPOSIT') @else btn-soft @endif btn-pill mb-1 mr-3">คำร้องการฝากเงิน</a>
                    <a href="@if($type == 'TRANSFER') #! @else {{ route('transaction-transfer') }} @endif" class="btn btn-sm btn-primary @if($type == 'TRANSFER') @else btn-soft @endif btn-pill mb-1 mr-3">รายการโอนในระบบ</a>
                    <a href="@if($type == 'WITHDRAW') #! @else {{ route('transaction-withdraw') }} @endif" class="btn btn-sm btn-primary @if($type == 'WITHDRAW') @else btn-soft @endif btn-pill mb-1 mr-3">การถอนเงิน</a>
                    <a href="@if($type == 'ADJUST') #! @else {{ route('transaction-adjust') }} @endif" class="btn btn-sm btn-primary @if($type == 'ADJUST') @else btn-soft @endif btn-pill mb-1 mr-3">Adjust</a>
                </span>
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-0 pt-2">
                <div class="table-responsive mt-2">

                    <div class="row">
                        <div class="col-md-12 px-5">
                            <table class="table table-align-middle border-bottom mb-6 mt-2">

                                <thead>
                                    <tr class="text-muted fs--13 bg-light">
                                        <th>
                                            <span class="px-2 p-0-xs">
                                                ประเภทรายการ
                                            </span>
                                        </th>
                                        <th class="hidden-lg-down text-center">รายการของ</th>
                                        <th class="hidden-lg-down text-center">วัน-เวลา</th>
                                        <th class="hidden-lg-down text-center">ไปยังบัญชี</th>
                                        <th class="hidden-lg-down text-center">จำนวนเงิน</th>
                                        <th class="hidden-lg-down text-center">สลิป</th>
                                        <th class="hidden-lg-down text-center">สถานะ</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>

                                <tbody id="item_list">

                                    @foreach ($transaction as $key => $trans)

                                        <tr id="message_id_{{ $key }}" class="text-dark 
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
                                                        <span class="badge badge-primary font-weight-normal fs--16">
                                                            ปรับเปลี่ยน
                                                        </span>
                                                    @endif
                                                </p>
                                                @if(isset($trans->description))
                                                    <small><small><span class="text-danger">**</span> {{ $trans->description }}</small></small>
                                                @endif

                                                <!-- MOBILE ONLY ----------------------------------------------->
                                                <div class="fs--13 d-block d-xl-none">
                                                <span class="d-block text-muted">
                                                        วัน-เวลา : {{ date('d-m-Y', strtotime($trans->action_date)) }} | 
                                                        <small>{{ date('H:i:s', strtotime($trans->action_date)) }}</small>
                                                    </span>
                                                    <span class="d-block text-muted">
                                                        ไปยัง : 
                                                        @if(isset($trans->by_admin))
                                                            <small>
                                                                <strong>ผู้ดูแลระบบ : {{ $trans->by_admin }}</strong>
                                                            </small>
                                                            <small><i class="fi fi-arrow-right-full text-primary"></i></small>
                                                            <small>
                                                                @if($trans->to_default == 'Y')
                                                                    กระเป๋าหลัก
                                                                @else
                                                                    กระเป๋าเกม : {{ $trans->to_game }}
                                                                @endif
                                                            </small>
                                                        @else
                                                            @if($trans->code == 'DEPOSIT')
                                                                {{ $trans->cbank_name }} | 
                                                                <small>{{ $trans->account_name }}</small> | 
                                                                <small>{{ $trans->account_number }}</small>
                                                            @elseif($trans->code == 'WITHDRAW')
                                                                {{ $trans->ubank_name }} | 
                                                                <small>{{ $trans->bank_account_name }}</small> | 
                                                                <small>{{ $trans->bank_account_number }}</small>
                                                            @elseif($trans->code == 'TRANSFER')
                                                                <small>
                                                                    @if($trans->from_default == 'Y')
                                                                        กระเป๋าหลัก
                                                                    @else
                                                                        กระเป๋าเกม : {{ $trans->from_game }}
                                                                    @endif
                                                                </small>
                                                                <small><i class="fi fi-arrow-right-full text-primary"></i></small>
                                                                <small>
                                                                    @if($trans->to_default == 'Y')
                                                                        กระเป๋าหลัก
                                                                    @else
                                                                        กระเป๋าเกม : {{ $trans->to_game }}
                                                                    @endif
                                                                </small>
                                                            @endif
                                                        @endif
                                                    </span>
                                                    <span class="d-block text-muted">
                                                        จำนวน : <small><strong class=" @if($trans->code == 'DEPOSIT') text-success 
                                                            @elseif($trans->code == 'WITHDRAW') text-danger 
                                                            @elseif($trans->code == 'TRANSFER') text-warning
                                                            @elseif($trans->code == 'ADJUST') text-primary
                                                            @endif "
                                                        >
                                                            {{ number_format($trans->amount) }}
                                                        </strong> {{ $trans->currency }}</small>
                                                        @if(isset($trans->slip))
                                                        <a href="#!" title="ดูสลิปโอนเงิน" 
                                                            data-toggle="modal" data-target="#paymentSlipModal" 
                                                                onClick="setImagePaymentTransactionSlip(
                                                                    '{{ $trans->slip }}', '{{ $trans->from_bank_nane }}', '{{ $trans->from_bank_name_en }}', 
                                                                    '{{ $trans->from_account_name }}', '{{ $trans->from_account_number }}', 
                                                                    '{{ $trans->payment_date }}', '{{ $trans->payment_time }}')">
                                                            <i class="fi fi-image"></i>
                                                        </a>
                                                        @endif
                                                    </span>
                                                    <span class="d-block text-muted">
                                                        @if($trans->status == 'CO') 
                                                            <small class="badge badge-success font-weight-normal">ยืนยันแล้ว</small>
                                                        @elseif($trans->status == 'VO')
                                                            <small class="badge badge-danger font-weight-normal">ปฏิเสธแล้ว</small>
                                                        @else
                                                            <small class="badge badge-secondary font-weight-normal">รอยืนยัน</small>
                                                        @endif
                                                    </span>
                                                </div>
                                                <!-- /MOBILE ONLY ----------------------------------------------->
                                            </td>

                                            <td class="hidden-lg-down text-center" style="line-height: 16px;">
                                                {{ $trans->username }}<br/>
                                                <small class="">{{ $trans->name }}</small>
                                            </td>

                                            <td class="hidden-lg-down text-center" style="line-height: 17px;">
                                                {{ date('d-m-Y', strtotime($trans->action_date)) }}<br/>
                                                <small>{{ date('H:i:s', strtotime($trans->action_date)) }}</small>
                                            </td>

                                            <td class="hidden-lg-down text-center" style="line-height: 16px;">
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

                                            <td class="hidden-lg-down text-center">
                                                <strong class=" @if($trans->code == 'DEPOSIT') text-success 
                                                            @elseif($trans->code == 'WITHDRAW') text-danger 
                                                            @elseif($trans->code == 'TRANSFER') text-warning
                                                            @elseif($trans->code == 'ADJUST') text-primary
                                                            @endif "
                                                >{{ number_format($trans->amount) }}
                                                </strong>
                                            </td>

                                            <td class="hidden-lg-down text-center">
                                                @if(isset($trans->slip))
                                                    <a href="#!" title="ดูสลิปโอนเงิน" 
                                                        data-toggle="modal" data-target="#paymentSlipModal" 
                                                        onClick="setImagePaymentTransactionSlip(
                                                            '{{ $trans->slip }}', '{{ $trans->from_bank_nane }}', '{{ $trans->from_bank_name_en }}', 
                                                                    '{{ $trans->from_account_name }}', '{{ $trans->from_account_number }}', 
                                                                    '{{ $trans->payment_date }}', '{{ $trans->payment_time }}')">
                                                        <i class="fi fi-image"></i>
                                                    </a>
                                                @endif
                                            </td>

                                            <td class="hidden-lg-down text-center">
                                                @if($trans->status == 'CO') 
                                                    <small class="badge badge-success font-weight-normal">ยืนยันแล้ว</small>
                                                @elseif($trans->status == 'VO')
                                                    <small class="badge badge-danger font-weight-normal">ปฏิเสธแล้ว</small>
                                                @else
                                                    <small class="badge badge-secondary font-weight-normal">รอยืนยัน</small>
                                                @endif
                                            </td>

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

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

                <!-- options and pagination -->
                <div class="row text-center-xs">

                    <div class="hidden-lg-down col-12 col-xl-6">

                        <!-- SELECTED ITEMS -->
                        
                        <!-- /SELECTED ITEMS -->

                    </div>


                    <div class="col-12 col-xl-6">

                        <!-- pagination -->
                        <nav aria-label="pagination">
                            <ul class="pagination pagination-pill justify-content-end justify-content-center justify-content-md-end">

                                <li class="{{ $transaction->onFirstPage() ? 'page-item btn-pill disabled' : 'page-item btn-pill' }}">
                                    <a class="page-link" href="{{ $transaction->previousPageUrl() }}" tabindex="-1" aria-disabled="true">ก่อนหน้า</a>
                                </li>
                                
                                <li class="page-item active" aria-current="page">
                                    {{ $transaction->links() }}
                                </li>
                                
                                <li class="{{ $transaction->currentPage() == $transaction->lastPage() ? 'page-item disabled' : 'page-item' }}">
                                    <a class="page-link" href="{{ $transaction->nextPageUrl() }}">ถัดไป</a>
                                </li>

                            </ul>

                            <div class="justify-content-end justify-content-center justify-content-md-end text-right">
                                <small>หน้า : {{ $transaction->currentPage() }} / {{ $transaction->lastPage() }}</small>
                            </div>
                        </nav>
                        <!-- pagination -->

                    </div>

                </div>
                
            </div>
        </div>
    </div>
</div>
<style>
    .table-responsive {
        overflow-x: initial;
    }
</style>
@endsection

@section('modal')
    @include('user.modal.payment_slip')
@endsection