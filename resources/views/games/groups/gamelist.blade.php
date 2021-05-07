@extends('layouts.core')

@section('content')
<div class="row gutters-sm">

    @include('games.groups.groupmenu')

    <!-- inbox list -->
    <div class="col-12 col-lg-9 col-xl-10">


        <!-- portlet -->
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">

                    <a href="/games/groups" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3">
                        < Back
                    </a>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    Game Lists By {{ $is_group }}
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
                                            GAME NAME
                                        </span>
                                    </th>
                                    <th class="hidden-lg-down text-center">URL</th>
                                    <th class="hidden-lg-down text-center">TOKEN</th>
                                    <th class="w--200 hidden-lg-down text-center">STATUS</th>
                                    <th class="w--200">&nbsp;</th>
                                </tr>
                            </thead>

                            <tbody id="item_list">

                                @foreach($games as $key => $game)
                                <tr id="message_id_{{ $key }}" class="text-dark">

                                    <td class="hidden-lg-down">
                                        <label class="form-checkbox form-checkbox-secondary float-start">
                                            <input type="checkbox" name="item_id[]" value="{{ $key }}">
                                            <i></i>
                                        </label>
                                    </td>

                                    <td style="line-height: 17px;">
                                        <p class="mb-0 d-flex">
                                            <strong class="text-dark">{{ $game->name }}</strong> 
                                        </p>

                                        <!-- MOBILE ONLY -->
                                        <div class="fs--13 d-block d-xl-none">
                                            @if($game->is_active == 'Y')
                                                <span class="badge badge-success font-weight-normal mt-1">ACTIVE</span>
                                            @else
                                                <span class="badge badge-danger font-weight-normal mt-1">INACTIVE</span>
                                            @endif
                                        </div>
                                        <!-- /MOBILE ONLY -->
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        {{ $game->url }}
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        {{ $game->token }}
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        @if($game->is_active == 'Y')
                                            <span class="badge badge-success font-weight-normal mt-1">ACTIVE</span>
                                        @else
                                            <span class="badge badge-danger font-weight-normal mt-1">INACTIVE</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a class="text-truncate mr-2" href="#!" title="ย้ายกลุ่มเกม" data-toggle="modal" data-target="#gameTransferModal" onClick="setGameDataTransfer({{ $game->id }})">
                                            <i class="fi fi-arrow-right-3 text-dark"></i>
                                        </a>

                                        <a class="text-truncate mr-2" href="#!" title="แก้ไข" data-toggle="modal" data-target="#gameEditModal" onClick="setGameDataEdit({{ $game->id }}, '{{ $game->name }}', '{{ $game->url }}', '{{ $game->token }}', {{ $game->game_group_id }})">
                                            <i class="fi fi-pencil"></i>
                                        </a>

                                        <a class="text-truncate mr-2" href="/games/active/{{ $game->id }}/{{ $game->name }}">
                                            @if($game->is_active == 'Y')
                                                <span class="text-success" title="ปิดการใช้งาน"><i class="fi fi-eye"></i></span>
                                            @else
                                                <span class="text-danger" title="เปิดการใช้งาน"><i class="fi fi-eye-disabled"></i></span>
                                            @endif
                                        </a>

                                        <a  href="#!" 
                                            class="text-truncate js-ajax-confirm" 
                                            data-href="/games/delete/{{ $game->id }}/{{ $game->name }}"
                                            data-ajax-confirm-body="ยืนยันการลบเกม {{ $game->name }} ?" 

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
    @include('games.groups.modal.transfer')
@endsection