@extends('layouts.core')

@section('title', 'Payment Transaction')

@section('content')
<div class="row gutters-sm">
    <div class="col-12">
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    รายการเคลื่อนไหวทางการเงิน
                </span>
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-0">
                <div class="table-responsive">

                    <table class="table table-align-middle border-bottom mb-6">

                        <thead>
                            <tr class="text-muted fs--13 bg-light">
                                <th class="w--30 hidden-lg-down">
                                    <label class="form-checkbox form-checkbox-primary float-start">
                                        <input class="checkall" data-checkall-container="#item_list" type="checkbox" name="checkbox">
                                        <i></i>
                                    </label>
                                </th>
                                <th>
                                    <span class="px-2 p-0-xs">
                                        ประเภทรายการ
                                    </span>
                                </th>
                                <th class="hidden-lg-down text-center">ผู้ทำรายการ</th>
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
                                                                @if($trans->type == 'ฝาก') bg-deposit 
                                                                @elseif($trans->type == 'ถอน') bg-withdraw  
                                                                @elseif($trans->type == 'ย้าย') bg-transfer
                                                                @endif ">

                                    <td class="hidden-lg-down">
                                        <label class="form-checkbox form-checkbox-secondary float-start">
                                            <input type="checkbox" name="item_id[]" value="{{ $key }}">
                                            <i></i>
                                        </label>
                                    </td>

                                    <td>
                                        <p class="mb-0 d-flex">
                                            <span class="badge 
                                                        @if($trans->type == 'ฝาก') badge-success 
                                                        @elseif($trans->type == 'ถอน') badge-danger 
                                                        @elseif($trans->type == 'ย้าย') badge-warning
                                                        @endif 
                                                        font-weight-normal fs--16"
                                            >{{ $trans->type }}
                                            </span>
                                        </p>

                                        <!-- MOBILE ONLY -->
                                        <div class="fs--13 d-block d-xl-none">
                                            <span class="d-block text-muted"></span>
                                            <span class="d-block text-muted"></span>
                                        </div>
                                        <!-- /MOBILE ONLY -->
                                    </td>

                                    <td class="hidden-lg-down text-center" style="line-height: 16px;">
                                        {{ $trans->username }}<br/>
                                        <small class="">{{ $trans->name }}</small>
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        {{ $trans->action_date }}
                                    </td>

                                    <td class="hidden-lg-down text-center" style="line-height: 16px;">
                                        @if($trans->type == 'ฝาก')
                                            {{ $trans->bank_name }}<br/>
                                            <small>{{ $trans->account_name }}</small><br/>
                                            <small>{{ $trans->account_number }}</small>
                                        @elseif($trans->type == 'ถอน')
                                            {{ $trans->user_bank_name }}<br/>
                                            <small>{{ $trans->bank_account_name }}</small><br/>
                                            <small>{{ $trans->bank_account_number }}</small>
                                        @elseif($trans->type == 'ย้าย')
                                            <small>
                                                @if($trans->from_default == 'Y')
                                                    กระเป๋าหลัก
                                                @else
                                                    กระเป๋าเกม : {{ $trans->from_game }}
                                                @endif
                                            </small><br/>
                                            <small>-></small></br>
                                            <small>
                                                @if($trans->to_default == 'Y')
                                                    กระเป๋าหลัก
                                                @else
                                                    กระเป๋าเกม : {{ $trans->to_game }}
                                                @endif
                                            </small>
                                        @endif
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        <strong class=" @if($trans->type == 'ฝาก') text-success 
                                                    @elseif($trans->type == 'ถอน') text-danger 
                                                    @elseif($trans->type == 'ย้าย') text-warning
                                                    @endif "
                                        >{{ number_format($trans->amount) }}
                                        </strong>
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        @if(isset($trans->slip))
                                            <a href="{{ asset('slip/'.$trans->slip) }}" target="_blank"><i class="fi fi-image"></i></a>
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
                                                class="js-ajax-confirm btn btn-success btn-sm btn-vv-sm ml-0 rounded" 
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
                                                class="js-ajax-confirm btn btn-danger btn-sm btn-vv-sm ml-0 rounded" 
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
    </div>
</div>
@endsection