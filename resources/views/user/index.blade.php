@extends('layouts.core')

@section('title', 'Users Menagement')

@section('content')
<div class="row gutters-sm">

    <!-- navigation -->
    <div class="col-12 col-lg-3 col-xl-2">

        <nav class="nav-deep nav-deep-light mb-2">

            <!-- mobile only -->
            <button class="clearfix btn btn-toggle btn-sm btn-block text-align-left shadow-md border rounded mb-1 d-block d-lg-none" data-target="#nav_responsive" data-toggle-container-class="d-none d-sm-block bg-white shadow-md border animate-fadein rounded p-3">
                <span class="group-icon px-2 py-2 float-start">
                    <i class="fi fi-bars-2"></i>
                    <i class="fi fi-close"></i>
                </span>

                <span class="h5 py-2 m-0 float-start font-weight-light">
                    Inbox
                </span>
            </button>


            <!-- navigation -->
            <ul id="nav_responsive" class="nav flex-column d-none d-lg-block">

                <li class="nav-item active">
                    <a class="nav-link px-0" href="{{ url('/users') }}">
                        <i class="fi fi-arrow-end m-0 fs--12"></i> 
                        <span class="px-2 d-inline-block">
                            All Users
                        </span>
                    </a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link px-0" href="{{ url('/users') }}">
                        <i class="fi fi-arrow-end m-0 fs--12"></i> 
                        <span class="px-2 d-inline-block">
                            Active Users
                        </span>
                    </a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link px-0" href="{{ url('/users') }}">
                        <i class="fi fi-arrow-end m-0 fs--12"></i> 
                        <span class="px-2 d-inline-block">
                            InActive Users <span class="badge badge-warning float-end font-weight-normal mt-1">{{ count($inactive) }}</span>
                        </span>
                    </a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link px-0" href="{{ url('/users') }}">
                        <i class="fi fi-arrow-end m-0 fs--12"></i> 
                        <span class="px-2 d-inline-block">
                            Deleted Users
                        </span>
                    </a>
                </li>

            </ul>

        </nav>

    </div>
    <!-- /navigation -->


    <!-- inbox list -->
    <div class="col-12 col-lg-9 col-xl-10">


        <!-- portlet -->
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">

                    <a href="message-write.html" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3">
                        + Add User
                    </a>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    All Users
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
                                    <th class="w--30 hidden-lg-down">
                                        <label class="form-checkbox form-checkbox-primary float-start">
                                            <input class="checkall" data-checkall-container="#item_list" type="checkbox" name="checkbox">
                                            <i></i>
                                        </label>
                                    </th>
                                    <th>
                                        <span class="px-2 p-0-xs">
                                            USERNAME
                                        </span>
                                    </th>
                                    <th class="w--100 hidden-lg-down text-center">WALLET</th>
                                    <th class="w--200 hidden-lg-down text-center">PHONE</th>
                                    <th class="w--100 hidden-lg-down text-center">LINE</th>
                                    <th class="w--100 hidden-lg-down text-center">CURRENCY</th>
                                    <th class="w--100 hidden-lg-down text-center">STATUS</th>
                                    <th class="w--60">&nbsp;</th>
                                </tr>
                            </thead>

                            <tbody id="item_list">

                                @foreach ($users as $key => $user)
                                    @if($user->status != 'DL')

                                    <!-- user -->
                                    <tr id="message_id_{{ $key }}" class="text-dark">

                                        <td class="hidden-lg-down">
                                            <label class="form-checkbox form-checkbox-secondary float-start">
                                                <input type="checkbox" name="item_id[]" value="{{ $key }}">
                                                <i></i>
                                            </label>
                                        </td>

                                        <td style="line-height: 17px;">
                                            <p class="mb-0 d-flex">
                                                <strong class="text-dark">{{ $user->username }}</strong> 
                                                <a href="#!" data-toggle="modal" data-target="#exampleModal">
                                                    <i class="fi fi-dots-horizontal-full d-block fs--20 ml-2" style="height: 10px; margin-top: -6px;"></i>
                                                </a>
                                            </p>
                                            <small style="font-size: 70%;">{{ $user->name }}</small>

                                            <!-- MOBILE ONLY -->
                                            <div class="fs--13 d-block d-xl-none">
                                                <span class="d-block text-muted">{{ $user->phone }}</span>
                                                <span class="d-block text-muted">{{ $user->line }}</span>
                                                <span class="d-block font-weight-medium">{{ $user->is_active }}</span>
                                            </div>
                                            <!-- /MOBILE ONLY -->
                                        </td>

                                        <td class="hidden-lg-down text-center">
                                            is_wallet
                                        </td>

                                        <td class="hidden-lg-down text-center">
                                            {{ $user->phone }}
                                        </td>

                                        <td class="hidden-lg-down text-center">
                                            @if($user->line != '')
                                                <a href="https://line.me/R/ti/p/{{ $user->line }}" target="_blank">{{ $user->line }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="hidden-lg-down text-center">
                                            {{ $user->currency }}
                                        </td>

                                        <td class="hidden-lg-down text-center">
                                            @if($user->is_active == 'Y')
                                                <span class="badge badge-success float-end font-weight-normal mt-1">ACTIVE</span>
                                            @else
                                                <span class="badge badge-danger float-end font-weight-normal mt-1">INACTIVE</span>
                                            @endif
                                        </td>

                                        <td class="text-align-end">

                                            <div class="dropdown">

                                                <a href="#" class="btn btn-sm btn-light rounded-circle" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                                    <span class="group-icon">
                                                        <i class="fi fi-dots-vertical-full"></i>
                                                        <i class="fi fi-close"></i>
                                                    </span>
                                                </a>


                                                <div class="dropdown-menu dropdown-menu-clean dropdown-click-ignore max-w-220">

                                                    <a class="dropdown-item text-truncate" href="/users/active/{{ $user->id }}/{{ $user->username }}">
                                                        <i class="fi fi-box"></i>
                                                        @if($user->is_active == 'Y')
                                                            <span class="text-danger">ปิดใช้งาน</span>
                                                        @else
                                                            <span class="text-success">เปิดใช้งาน</span>
                                                        @endif
                                                    </a>

                                                    <a	 href="#!" 
                                                        class="dropdown-item text-truncate js-ajax-confirm" 
                                                        data-href="/users/delete/{{ $user->id }}/{{ $user->username }}"
                                                        data-ajax-confirm-body="ยืนยันการลบบัญชีผู้ใช้งาน {{ $user->username }} ?" 

                                                        data-ajax-confirm-mode="ajax" 
                                                        data-ajax-confirm-method="GET" 

                                                        data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                                                        data-ajax-confirm-btn-yes-text="ลบข้อมูล" 
                                                        data-ajax-confirm-btn-yes-icon="fi fi-check" 

                                                        data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                                                        data-ajax-confirm-btn-no-text="ยกเลิก" 
                                                        data-ajax-confirm-btn-no-icon="fi fi-close"

                                                        data-ajax-confirm-success-target="#message_id_{{ $key }}" 
                                                        data-ajax-confirm-success-target-action="remove">
                                                        <i class="fi fi-thrash text-danger"></i>
                                                        ลบผู้ใช้
                                                    </a>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>
                                    <!-- /user -->
                                    @endif
                                @endforeach

                            </tbody>

                        </table>

                    </div>



                    <!-- options and pagination -->
                    <div class="row text-center-xs">

                        <div class="hidden-lg-down col-12 col-xl-6">

                            <!-- SELECTED ITEMS -->
                            <div class="dropup">

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

                            </div>
                            <!-- /SELECTED ITEMS -->

                        </div>


                        <div class="col-12 col-xl-6">

                            <!-- pagination -->
                            <nav aria-label="pagination">
                                <ul class="pagination pagination-pill justify-content-end justify-content-center justify-content-md-end">

                                    <li class="{{ $users->onFirstPage() ? 'page-item btn-pill disabled' : 'page-item btn-pill' }}">
                                        <a class="page-link" href="{{ $users->previousPageUrl() }}" tabindex="-1" aria-disabled="true">Prev</a>
                                    </li>
                                    
                                    <li class="page-item active" aria-current="page">
                                        {{ $users->links() }}
                                    </li>
                                    
                                    <li class="{{ $users->currentPage() == $users->lastPage() ? 'page-item disabled' : 'page-item' }}">
                                        <a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a>
                                    </li>

                                </ul>

                                <div class="justify-content-end justify-content-center justify-content-md-end text-right">
                                    <small>หน้า : {{ $users->currentPage() }} / {{ $users->lastPage() }}</small>
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