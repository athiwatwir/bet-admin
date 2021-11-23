@extends('layouts.core')

@section('title', 'รายการเกม')

@section('content')
<div class="row gutters-sm">

    <!-- inbox list -->
    <div class="col-12 col-lg-12 col-xl-12">


        <!-- portlet -->
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">

                    <button type="button" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3" data-toggle="modal" data-target="#gameCreateModal">
                        + เพิ่มเกม
                    </button>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    รายการเกมทั้งหมด
                </span>
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-2 px-5">

                <table class="table-datatable table table-bordered table-hover table-striped"
                    data-lng-empty="ไม่มีข้อมูล..." 
                    data-lng-page-info="แสดงผลเกมที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ เกม" 
                    data-lng-filtered="(filtered from _MAX_ total entries)" 
                    data-lng-loading="กำลังโหลด..." 
                    data-lng-processing="กำลังดำเนินการ..." 
                    data-lng-search="ค้นหาเกม..." 
                    data-lng-norecords="ไม่มีเกมที่ค้นหา..." 
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
                            <th class="w--30 text-center">#</th>
                            <th class="w--120text-center">โลโก้</th>
                            <th>ชื่อเกม</th>
                            <th class="text-center">URL</th>
                            <th class="text-center">TOKEN</th>
                            <th class="w--200 text-center">กลุ่มเกม</th>
                            <th class="w--100 text-center">สถานะ</th>
                            <th class="w--100">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($games as $key => $game)
                        <tr class="text-dark">

                            <td class="text-center">
                                {{ $key + 1 }}
                            </td>

                            <td class="text-center">
                                <img src="{{ asset('logogames/'.$game->logo) }}" width="115">
                            </td>

                            <td style="line-height: 17px;">
                                <p class="mb-0 d-flex">
                                    <strong class="text-dark">{{ $game->name }}</strong> 
                                </p>
                            </td>

                            <td class="text-center">
                                {{ $game->url }}
                            </td>

                            <td class="text-center">
                                {{ $game->token }}
                            </td>

                            <td class="text-center">
                                <a href="/games/groups/{{ $game->group_name }}/{{ $game->group_id }}/game-list">{{ $game->group_name }}</a>
                            </td>

                            <td class="text-center">
                                @if($game->is_active == 'Y')
                                    <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                @else
                                    <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                @endif
                            </td>

                            <td class="text-center">

                                <a class="text-truncate mr-2" href="#!" title="แก้ไข" data-toggle="modal" data-target="#gameEditModal" onClick="setGameDataEdit({{ $game->id }}, '{{ $game->name }}', '{{ $game->url }}', '{{ $game->token }}', '{{ $game->logo }}')">
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

                    <tfoot>
                        <tr class="text-muted fs--13">
                            <th class="w--30 text-center">#</th>
                            <th class="w--120text-center">โลโก้</th>
                            <th>ชื่อเกม</th>
                            <th class="text-center">URL</th>
                            <th class="text-center">TOKEN</th>
                            <th class="w--200 text-center">กลุ่มเกม</th>
                            <th class="w--100 text-center">สถานะ</th>
                            <th class="w--100">&nbsp;</th>
                        </tr>
                    </tfoot>

                </table>

            </div>
            <!-- /portlet : body -->

        </div>
        <!-- /portlet -->


    </div>
    <!-- /inbox list -->

</div>
<style>
    .dt-buttons.btn-group.flex-wrap {
        display: none;
    }
</style>
@endsection

@section('modal')
    @include('games.modal.add')

    @include('games.modal.edit')
@endsection