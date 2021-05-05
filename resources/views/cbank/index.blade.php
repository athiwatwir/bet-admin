@extends('layouts.core')

@section('title', 'Master Banking Management')

@section('content')
<div class="row gutters-sm">
    <div class="col-12 col-lg-12 col-xl-12">
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">

                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createCBankModal" style="box-shadow: 2px 2px 4px #aaa;"><i class="fi fi-plus"></i> เพิ่มบัญชีธนาคาร</button>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    All Banks
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
                                        ชื่อธนาคาร
                                    </span>
                                </th>
                                <th class="w--200 hidden-lg-down text-center">ชื่อบัญชี</th>
                                <th class="w--200 hidden-lg-down text-center">เลขบัญชี</th>
                                <th class="w--100 hidden-lg-down text-center">สถานะ</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>

                        <tbody id="item_list">

                            @foreach ($cbanks as $key => $cbank)

                                <!-- user -->
                                <tr id="message_id_{{ $key }}" class="text-dark">

                                    <td class="hidden-lg-down">
                                        <label class="form-checkbox form-checkbox-secondary float-start">
                                            <input type="checkbox" name="item_id[]" value="{{ $key }}">
                                            <i></i>
                                        </label>
                                    </td>

                                    <td style="line-height: 17px;">
                                        <p class="mb-0">
                                            <strong class="text-dark">{{ $cbank->bank_name }}</strong><br/>
                                            <small>{{ $cbank->bank_name_en }}</small>
                                        </p>

                                        <!-- MOBILE ONLY -->
                                        <div class="fs--13 d-block d-xl-none">
                                            <span class="d-block text-muted">{{ $cbank->account_name }}</span>
                                            <span class="d-block text-muted">{{ $cbank->account_number }}</span>
                                            <span class="d-block font-weight-medium">
                                                @if($cbank->is_active == 'Y') 
                                                    <small class="badge badge-success font-weight-normal">ACTIVE</small>
                                                @else 
                                                    <small class="badge badge-danger font-weight-normal">INACTIVE</small>
                                                @endif
                                            </span>
                                        </div>
                                        <!-- /MOBILE ONLY -->
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        {{ $cbank->account_name }}
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        {{ $cbank->account_number }}
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        @if($cbank->is_active == 'Y') 
                                            <small class="badge badge-success font-weight-normal">ACTIVE</small>
                                        @else 
                                            <small class="badge badge-danger font-weight-normal">INACTIVE</small>
                                        @endif
                                    </td>

                                    <td class="text-align-end">

                                        <div class="dropdown">

                                        <button class="btn btn-success btn-sm btn-vv-sm rounded" title="แก้ไขบัญชีธนาคาร" 
                                            data-toggle="modal" data-target="#editCBankModal" 
                                            onClick="setDataEditModal({{ $cbank->id }}, {{ $cbank->bank_id }}, '{{ $cbank->account_name }}', {{ $cbank->account_number }}, '{{ $cbank->is_active }}')"
                                        >
                                            <i class="fi fi-pencil mr-0"></i>
                                        </button>

                                        <a	href="#!" 
                                            class="js-ajax-confirm btn btn-danger btn-sm btn-vv-sm ml-0 rounded" 
                                            data-href="/delete-cbank/{{ $cbank->id }}"
                                            data-ajax-confirm-body="<center>
                                                                        <h4 class='mb-2'>ยืนยันการลบบัญชีธนาคาร ? </h4>
                                                                        {{ $cbank->bank_name }}
                                                                        {{ $cbank->account_name }} : {{ $cbank->account_number }}
                                                                    </center>" 

                                            data-ajax-confirm-method="GET" 

                                            data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                                            data-ajax-confirm-btn-yes-text="ลบบัญชี" 
                                            data-ajax-confirm-btn-yes-icon="fi fi-check" 

                                            data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                                            data-ajax-confirm-btn-no-text="ยกเลิก" 
                                            data-ajax-confirm-btn-no-icon="fi fi-close">
                                            <i class="fi fi-thrash mr-0"></i>
                                        </a>

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


@section('modal')
    @include('cbank.modal.add')

    @include('cbank.modal.edit')
@endsection