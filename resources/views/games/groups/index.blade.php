@extends('layouts.core')

@section('title', 'กลุ่มเกม')

@section('content')
<div class="row gutters-sm">

    <!-- inbox list -->
    <div class="col-12 col-lg-12 col-xl-12">


        <!-- portlet -->
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">

                    <button type="button" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3" data-toggle="modal" data-target="#groupGameCreateModal">
                        + เพิ่มกลุ่ม
                    </button>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    กลุ่มเกมทั้งหมด
                </span>
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-2 px-5">

                <table class="table-datatable table table-bordered table-hover table-striped"
                    data-lng-empty="ไม่มีข้อมูล..." 
                    data-lng-page-info="แสดงผลกลุ่มเกมที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ กลุ่มเกม" 
                    data-lng-filtered="(filtered from _MAX_ total entries)" 
                    data-lng-loading="กำลังโหลด..." 
                    data-lng-processing="กำลังดำเนินการ..." 
                    data-lng-search="ค้นหากลุ่มเกม..." 
                    data-lng-norecords="ไม่มีกลุ่มเกมที่ค้นหา..." 
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
                            <th>ชื่อกลุ่ม</th>
                            <th class="w--200 text-center">รายการเกมในกลุ่ม</th>
                            <th class="w--200 text-center">สถานะ</th>
                            <th class="w--200">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($groups as $key => $group)
                        <tr class="text-dark">

                            <td class="text-center">
                                <small>{{ $key + 1 }}.</small>
                            </td>

                            <td style="line-height: 17px;">
                                <p class="mb-0 d-flex">
                                    <strong class="text-dark">{{ $group->name }}</strong> 
                                </p>
                            </td>

                            <td class="text-center">
                                <small>
                                    @if($group->games_count > 0)
                                        <a href="/games/groups/{{ $group->name }}/{{ $group->id }}/game-list">ดูรายการเกม <span class="badge badge-info font-weight-normal ml-1">{{ $group->games_count }}</span></a>
                                    @else
                                        ไม่มีเกมอยู่ในกลุ่ม
                                    @endif
                                </small>
                            </td>

                            <td class="text-center">
                                @if($group->is_active == 'Y')
                                    <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                @else
                                    <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a class="text-truncate mr-2" href="#!" title="แก้ไข" data-toggle="modal" data-target="#groupGameEditModal" onClick="setGameGroupDataEdit({{ $group->id }}, '{{ $group->name }}')">
                                    <i class="fi fi-pencil"></i>
                                </a>

                                @if($group->games_count == 0)
                                    <a class="text-truncate mr-2" href="/games/groups/active/{{ $group->id }}/{{ $group->name }}">
                                        @if($group->is_active == 'Y')
                                            <span class="text-success" title="ปิดการใช้งาน"><i class="fi fi-eye"></i></span>
                                        @else
                                            <span class="text-danger" title="เปิดการใช้งาน"><i class="fi fi-eye-disabled"></i></span>
                                        @endif
                                    </a>
                                @else
                                    <a href="#!" class="text-truncate mr-2" data-toggle="modal" data-target="#groupActiveModal" onClick="setGameGroupDataActive({{ $group->id }}, '{{ $group->name }}', {{ $group->games_count }})">
                                        @if($group->is_active == 'Y')
                                            <span class="text-success" title="ปิดการใช้งาน"><i class="fi fi-eye"></i></span>
                                        @else
                                            <span class="text-danger" title="เปิดการใช้งาน"><i class="fi fi-eye-disabled"></i></span>
                                        @endif
                                    </a>
                                @endif

                                @if($group->games_count == 0)
                                    <a  href="#!" 
                                        class="text-truncate js-ajax-confirm" 
                                        data-href="/games/groups/delete/{{ $group->id }}/{{ $group->name }}"
                                        data-ajax-confirm-body="<center>ยืนยันการลบกลุ่มเกม {{ $group->name }} ?</center>" 

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
                                @else
                                    <a  href="#!" 
                                        class="text-truncate js-ajax-confirm" 
                                        data-href="/games/groups/delete/{{ $group->id }}/{{ $group->name }}"
                                        data-ajax-confirm-body="<center>ยืนยันการลบกลุ่มเกม <strong>{{ $group->name }}</strong> ?<br/>
                                                                เกมที่มีในกลุ่มนี้จำนวน <span class='text-danger'>{{ $group->games_count }}</span> เกม จะถูกลบไปด้วย<br/>
                                                                กรุณายืนยัน</center>" 

                                        data-ajax-confirm-mode="ajax" 
                                        data-ajax-confirm-method="GET" 

                                        data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                                        data-ajax-confirm-btn-yes-text="ยืนยันการลบ" 
                                        data-ajax-confirm-btn-yes-icon="fi fi-check" 

                                        data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                                        data-ajax-confirm-btn-no-text="ยกเลิก" 
                                        data-ajax-confirm-btn-no-icon="fi fi-close"

                                        data-ajax-confirm-success-target="#message_id_{{ $key }}" 
                                        data-ajax-confirm-success-target-action="remove">
                                        <i class="fi fi-thrash text-danger"></i>
                                    </a>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                    </tbody>

                    <tfoot>
                        <tr class="text-muted fs--13">
                            <th class="w--30 text-center">#</th>
                            <th>ชื่อกลุ่ม</th>
                            <th class="w--200 text-center">รายการเกมในกลุ่ม</th>
                            <th class="w--200 text-center">สถานะ</th>
                            <th class="w--200">&nbsp;</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
            <!-- /portlet : body -->

        </div>
        <!-- /portlet -->


    </div>
    <!-- /inbox list -->
<style>
    .dt-buttons.btn-group.flex-wrap {
        display: none;
    }
</style>
</div>
@endsection

@section('modal')
    @include('games.groups.modal.add')

    @include('games.groups.modal.edit')

    @include('games.groups.modal.active')
@endsection