@extends('layouts.core')

@section('title', 'รายการลีกฟุตบอล')

@section('content')
<div class="row gutters-sm">

    <!-- inbox list -->
    <div class="col-12 col-lg-12 col-xl-12">


        <!-- portlet -->
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">

                    <button type="button" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3" data-toggle="modal" data-target="#leagueCreateModal">
                        + เพิ่มลีก
                    </button>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    รายการลีกทั้งหมด
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
                                            ชื่อลีก
                                        </span>
                                    </th>
                                    <th class="w--100 hidden-lg-down text-center">สถานะ</th>
                                    <th class="w--100">&nbsp;</th>
                                </tr>
                            </thead>

                            <tbody id="item_list">

                                @foreach($leagues as $key => $league)
                                <tr id="message_id_{{ $key }}" class="text-dark">

                                    <td class="hidden-lg-down text-center">
                                        {{ $key + 1 }}
                                        <!-- <label class="form-checkbox form-checkbox-secondary float-start">
                                            <input type="checkbox" name="item_id[]" value="{{ $key }}">
                                            <i></i>
                                        </label> -->
                                    </td>

                                    <td style="line-height: 17px;">
                                        <p class="mb-0 d-flex">
                                            <strong class="text-dark">{{ $league->name }}</strong> 
                                        </p>
                                        <small style="font-size: 70%;">{{ $league->name_en }}</small>

                                        <!-- MOBILE ONLY -->
                                        <div class="fs--13 d-block d-xl-none">
                                            <strong>สถานะ :</strong> 
                                            @if($league->is_active == 'Y')
                                                <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                            @else
                                                <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                            @endif
                                        </div>
                                        <!-- /MOBILE ONLY -->
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        @if($league->is_active == 'Y')
                                            <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                        @else
                                            <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                        @endif
                                    </td>

                                    <td class="text-center">

                                        <a class="text-truncate mr-2" href="#!" title="แก้ไข" data-toggle="modal" data-target="#leagueEditModal" onClick="setFootballLeagueDataEdit({{ $league->id }}, '{{ $league->name }}', '{{ $league->name_en }}')">
                                            <i class="fi fi-pencil"></i>
                                        </a>

                                        <a class="text-truncate mr-2" href="/football/leagues/active/{{ $league->id }}/{{ $league->name }}">
                                            @if($league->is_active == 'Y')
                                                <span class="text-success" title="ปิดการใช้งาน"><i class="fi fi-eye"></i></span>
                                            @else
                                                <span class="text-danger" title="เปิดการใช้งาน"><i class="fi fi-eye-disabled"></i></span>
                                            @endif
                                        </a>

                                        <a  href="#!" 
                                            class="text-truncate js-ajax-confirm" 
                                            data-href="/football/leagues/delete/{{ $league->id }}/{{ $league->name }}"
                                            data-ajax-confirm-body="ยืนยันการลบลีก {{ $league->name }} ?" 

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

                        </div>


                        <div class="col-12 col-xl-6">

                            <!-- pagination -->
                            <nav aria-label="pagination">
                                <ul class="pagination pagination-pill justify-content-end justify-content-center justify-content-md-end">

                                    <li class="{{ $leagues->onFirstPage() ? 'page-item btn-pill disabled' : 'page-item btn-pill' }}">
                                        <a class="page-link" href="{{ $leagues->previousPageUrl() }}" tabindex="-1" aria-disabled="true">ก่อนหน้า</a>
                                    </li>
                                    
                                    <li class="page-item active" aria-current="page">
                                        {{ $leagues->links() }}
                                    </li>
                                    
                                    <li class="{{ $leagues->currentPage() == $leagues->lastPage() ? 'page-item disabled' : 'page-item' }}">
                                        <a class="page-link" href="{{ $leagues->nextPageUrl() }}">ถัดไป</a>
                                    </li>

                                </ul>

                                <div class="justify-content-end justify-content-center justify-content-md-end text-right">
                                    <small>หน้า : {{ $leagues->currentPage() }} / {{ $leagues->lastPage() }}</small>
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
    @include('football.modal.add_league')

    @include('football.modal.edit_league')
@endsection