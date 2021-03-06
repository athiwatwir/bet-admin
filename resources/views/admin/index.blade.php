@extends('layouts.core')

@section('title', 'การจัดการผู้ดูแลระบบ')

@section('content')
<div class="row gutters-sm">

    <!-- navigation -->
    
    <!-- /navigation -->


    <!-- inbox list -->
    <div class="col-12 col-lg-12 col-xl-12">


        <!-- portlet -->
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">

                    <button type="button" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3" data-toggle="modal" data-target="#adminRegisterModal">
                        + เพิ่มผู้ดูแลระบบ
                    </button>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    ผู้ดูแลระบบทั้งหมด
                </span>
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-0">

                <form novalidate class="bs-validate" id="form_id" method="post" action="#!">
                @csrf
                    <input type="hidden" id="action" name="action" value=""><!-- value populated by js -->

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
                                            ชื่อผู้ใช้
                                        </span>
                                    </th>
                                    <th class="w--250 hidden-lg-down text-center">ตำแหน่ง</th>
                                    <th class="w--250 hidden-lg-down text-center">โทรศัพท์</th>
                                    <th class="w--150 hidden-lg-down text-center">ไลน์</th>
                                    <th class="w--150 hidden-lg-down text-center">สถานะ</th>
                                </tr>
                            </thead>

                            <tbody id="item_list">

                                @foreach ($admins as $key => $admin)
                                    <!-- admin -->
                                    <tr id="message_id_{{ $key }}" class="text-dark">

                                        <td class="hidden-lg-down text-center">
                                            {{ $key + 1 }}.
                                            <!-- <label class="form-checkbox form-checkbox-secondary float-start">
                                                <input type="checkbox" name="item_id[]" value="{{ $key }}">
                                                <i></i>
                                            </label> -->
                                        </td>

                                        <td style="line-height: 17px;">
                                            <a class="text-dark" href="/admins/{{ $admin->username }}/{{ $admin->id }}/view" title="ดูรายละเอียดของผู้ดูแลระบบนี้">
                                                <p class="mb-0 d-flex">
                                                    <strong class="text-dark">{{ $admin->username }}</strong> 
                                                </p>
                                                <small style="font-size: 70%;">ชื่อ-สกุล : {{ $admin->name }}</small>
                                            </a>

                                            <!-- MOBILE ONLY -->
                                            <div class="fs--13 d-block d-xl-none">
                                                <span class="d-block text-muted">ตำแหน่ง : role--0</span>
                                                <span class="d-block text-muted">โทรศัพท์ : {{ $admin->phone }}</span>
                                                @if($admin->line)
                                                    <span class="d-block text-muted">ไลน์ : <a href="https://line.me/R/ti/p/{{ $admin->line }}" target="_blank">{{ $admin->line }}</a></span>
                                                @endif
                                                <span class="d-block font-weight-medium">
                                                    @if($admin->is_active == 'Y')
                                                        <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                                    @else
                                                        <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                                    @endif
                                                </span>
                                            </div>
                                            <!-- /MOBILE ONLY -->
                                        </td>

                                        <td class="hidden-lg-down text-center">
                                            Role--0
                                        </td>

                                        <td class="hidden-lg-down text-center">
                                            {{ $admin->phone }}
                                        </td>

                                        <td class="hidden-lg-down text-center">
                                            @if($admin->line != '')
                                                <a href="https://line.me/R/ti/p/{{ $admin->line }}" target="_blank">{{ $admin->line }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="hidden-lg-down text-center">
                                            @if($admin->is_active == 'Y')
                                                <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                            @else
                                                <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                            @endif
                                        </td>

                                    </tr>
                                    <!-- /admin -->
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

                                    <li class="{{ $admins->onFirstPage() ? 'page-item btn-pill disabled' : 'page-item btn-pill' }}">
                                        <a class="page-link" href="{{ $admins->previousPageUrl() }}" tabindex="-1" aria-disabled="true">ก่อนหน้า</a>
                                    </li>
                                    
                                    <li class="page-item active" aria-current="page">
                                        {{ $admins->links() }}
                                    </li>
                                    
                                    <li class="{{ $admins->currentPage() == $admins->lastPage() ? 'page-item disabled' : 'page-item' }}">
                                        <a class="page-link" href="{{ $admins->nextPageUrl() }}">ถัดไป</a>
                                    </li>

                                </ul>

                                <div class="justify-content-end justify-content-center justify-content-md-end text-right">
                                    <small>หน้า : {{ $admins->currentPage() }} / {{ $admins->lastPage() }}</small>
                                </div>
                            </nav>
                            <!-- pagination -->

                        </div>

                    </div>
                    <!-- /options and pagination -->

                </form>

            </div>
            <!-- /portlet : body -->

        </div>
        <!-- /portlet -->


    </div>
    <!-- /inbox list -->

</div>
@endsection

@section('modal')
    @include('admin.modal.register')

    @include('admin.modal.edit')

    @include('admin.modal.repassword')
@endsection