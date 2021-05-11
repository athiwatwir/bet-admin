@extends('layouts.core')

@section('title', 'รายการบัญชีธนาคารสำหรับรับเงินโอน')

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
                    รายการบัญชีสำหรับรับเงินโอนทั้งหมด
                </span>
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-0">
                <div class="table-responsive">

                    <table class="table table-align-middle border-bottom mb-6">

                        <thead>
                            <tr class="text-muted fs--13 bg-light">
                                <th class="w--30 hidden-lg-down text-center">
                                    #
                                    <!-- <label class="form-checkbox form-checkbox-primary float-start">
                                        <input class="checkall" data-checkall-container="#item_list" type="checkbox" name="checkbox">
                                        <i></i>
                                    </label> -->
                                </th>
                                <th>
                                    <span class="px-2 p-0-xs">
                                        ชื่อธนาคาร
                                    </span>
                                </th>
                                <th class="w--200 hidden-lg-down text-center">ชื่อบัญชี</th>
                                <th class="w--200 hidden-lg-down text-center">เลขบัญชี</th>
                                <th class="w--100 hidden-lg-down text-center">สถานะ</th>
                                <th class="w--150">&nbsp;</th>
                            </tr>
                        </thead>

                        <tbody id="item_list">

                            @foreach ($cbanks as $key => $cbank)

                                <!-- user -->
                                <tr id="message_id_{{ $key }}" class="text-dark">

                                    <td class="hidden-lg-down text-center">
                                        {{ $key + 1 }}.
                                        <!-- <label class="form-checkbox form-checkbox-secondary float-start">
                                            <input type="checkbox" name="item_id[]" value="{{ $key }}">
                                            <i></i>
                                        </label> -->
                                    </td>

                                    <td style="line-height: 17px;">
                                        <p class="mb-0">
                                            <strong class="text-dark">{{ $cbank->bank_name }}</strong><br/>
                                            <small>{{ $cbank->bank_name_en }}</small>
                                        </p>

                                        <!-- MOBILE ONLY -->
                                        <div class="fs--13 d-block d-xl-none">
                                            <span class="d-block font-weight-medium"><strong>ชื่อบัญชี :</strong> {{ $cbank->account_name }}</span>
                                            <span class="d-block font-weight-medium"><strong>เลขที่บัญชี :</strong> {{ $cbank->account_number }}</span>
                                            <span class="d-block font-weight-medium">
                                                <strong>สถานะ :</strong>
                                                @if($cbank->is_active == 'Y') 
                                                    <small class="badge badge-success font-weight-normal">เปิดใช้งาน</small>
                                                @else 
                                                    <small class="badge badge-danger font-weight-normal">ปิดใช้งาน</small>
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
                                            <small class="badge badge-success font-weight-normal">เปิดใช้งาน</small>
                                        @else 
                                            <small class="badge badge-danger font-weight-normal">ปิดใช้งาน</small>
                                        @endif
                                    </td>

                                    <td class="text-center">

                                        <a class="text-truncate mr-1" href="#!" title="แก้ไขบัญชีธนาคาร" 
                                            data-toggle="modal" data-target="#editCBankModal" 
                                            onClick="setDataEditModal({{ $cbank->id }}, {{ $cbank->bank_id }}, '{{ $cbank->account_name }}', {{ $cbank->account_number }})"
                                        >
                                            <i class="fi fi-pencil mr-0"></i>
                                        </a>

                                        <a class="text-truncate mr-1" href="/active-cbank/{{ $cbank->id }}/{{ $cbank->account_name }}/{{ $cbank->account_number }}">
                                            @if($cbank->is_active == 'Y')
                                                <span class="text-success" title="ปิดการใช้งาน"><i class="fi fi-eye"></i></span>
                                            @else
                                                <span class="text-danger" title="เปิดการใช้งาน"><i class="fi fi-eye-disabled"></i></span>
                                            @endif
                                        </a>

                                        <a	href="#!" 
                                            class="js-ajax-confirm text-danger" 
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

                <!-- options and pagination -->
                <div class="row text-center-xs">

                    <div class="hidden-lg-down col-12 col-xl-6">

                        <!-- SELECTED ITEMS -->
                        <!-- <div class="dropup">

                            <a href="#" class="btn btn-sm btn-pill btn-light" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                <span class="group-icon">
                                    <i class="fi fi-dots-vertical-full"></i>
                                    <i class="fi fi-close"></i>
                                </span>
                                <span>Selected Items</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-clean dropdown-click-ignore max-w-250">

                                <a	 href="#" 
                                    class="dropdown-item text-truncate js-form-advanced-bulk" 
                                    data-js-form-advanced-bulk-hidden-action-id="#action" 
                                    data-js-form-advanced-bulk-hidden-action-value="myactionhere3" 
                                    data-js-form-advanced-bulk-container-items="#item_list" 
                                    data-js-form-advanced-bulk-required-selected="true" 
                                    data-js-form-advanced-bulk-required-txt-error="No Items Selected!" 
                                    data-js-form-advanced-bulk-required-txt-position="top-center" 
                                    data-js-form-advanced-bulk-submit-without-confirmation="true" 
                                    data-js-form-advanced-form-id="#form_id">
                                    <i class="fi fi-box"></i>
                                    Archive
                                </a>

                                <a	 href="#" 
                                    class="dropdown-item text-truncate js-form-advanced-bulk" 
                                    data-js-form-advanced-bulk-hidden-action-id="#action" 
                                    data-js-form-advanced-bulk-hidden-action-value="delete" 
                                    data-js-form-advanced-bulk-container-items="#item_list" 
                                    data-js-form-advanced-bulk-required-selected="true" 
                                    data-js-form-advanced-bulk-required-txt-error="No Items Selected!" 
                                    data-js-form-advanced-bulk-required-txt-position="top-center" 
                                    data-js-form-advanced-bulk-required-custom-modal="" 
                                    data-js-form-advanced-bulk-required-custom-modal-content-ajax="" 
                                    data-js-form-advanced-bulk-required-modal-type="danger" 
                                    data-js-form-advanced-bulk-required-modal-size="modal-md" 
                                    data-js-form-advanced-bulk-required-modal-txt-title="Please Confirm" 
                                    data-js-form-advanced-bulk-required-modal-txt-subtitle="Selected Items: no_selected" 
                                    data-js-form-advanced-bulk-required-modal-txt-body-txt="Are you sure? Delete no_selected selected items?" 
                                    data-js-form-advanced-bulk-required-modal-txt-body-info="Please note: this is a permanent action!" 
                                    data-js-form-advanced-bulk-required-modal-btn-text-yes="Delete" 
                                    data-js-form-advanced-bulk-required-modal-btn-text-no="Cancel" 
                                    data-js-form-advanced-bulk-submit-without-confirmation="false" 
                                    data-js-form-advanced-form-id="#form_id">
                                    <i class="fi fi-thrash text-danger"></i>
                                    ลบที่เลือก
                                </a>

                            </div>

                        </div> -->
                        <!-- /SELECTED ITEMS -->

                    </div>


                    <div class="col-12 col-xl-6">

                        <!-- pagination -->
                        <nav aria-label="pagination">
                            <ul class="pagination pagination-pill justify-content-end justify-content-center justify-content-md-end">

                                <li class="{{ $cbanks->onFirstPage() ? 'page-item btn-pill disabled' : 'page-item btn-pill' }}">
                                    <a class="page-link" href="{{ $cbanks->previousPageUrl() }}" tabindex="-1" aria-disabled="true">ก่อนหน้า</a>
                                </li>
                                
                                <li class="page-item active" aria-current="page">
                                    {{ $cbanks->links() }}
                                </li>
                                
                                <li class="{{ $cbanks->currentPage() == $cbanks->lastPage() ? 'page-item disabled' : 'page-item' }}">
                                    <a class="page-link" href="{{ $cbanks->nextPageUrl() }}">ถัดไป</a>
                                </li>

                            </ul>

                            <div class="justify-content-end justify-content-center justify-content-md-end text-right">
                                <small>หน้า : {{ $cbanks->currentPage() }} / {{ $cbanks->lastPage() }}</small>
                            </div>
                        </nav>
                        <!-- pagination -->

                    </div>

                    </div>
                    <!-- /options and pagination -->
            </div>
        </div>
    </div>
</div>
@endsection


@section('modal')
    @include('cbank.modal.add')

    @include('cbank.modal.edit')
@endsection