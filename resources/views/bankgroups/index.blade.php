@extends('layouts.core')

@section('title', 'การจัดการกลุ่มธนาคาร')

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

                    <a href="message-write.html" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3" data-toggle="modal" data-target="#bankGroupCreateModal">
                        + เพิ่มกลุ่มธนาคาร
                    </a>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    กลุ่มธนาคารทั้งหมด
                </span>
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-2 px-5">

                <table class="table-datatable table table-bordered table-hover table-striped"
                    data-lng-empty="ไม่มีข้อมูล..." 
                    data-lng-page-info="แสดงผลกลุ่มบัญชีที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ กลุ่มบัญชี" 
                    data-lng-filtered="(filtered from _MAX_ total entries)" 
                    data-lng-loading="กำลังโหลด..." 
                    data-lng-processing="กำลังดำเนินการ..." 
                    data-lng-search="ค้นหากลุ่มบัญชี..." 
                    data-lng-norecords="ไม่มีกลุ่มบัญชีที่ค้นหา..." 
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
                            <th>กลุ่มธนาคาร</th>
                            <th class="text-center">สถานะ</th>
                            <th class="w--150 text-center"></th>
                        </tr>
                    </thead>

                    <tbody>
                    <!-- Default Bank Group -->
                    @if(isset($group_default))
                        <tr class="text-dark">
                            <td class="hidden-lg-down text-center"></td>

                            <td style="line-height: 17px;">
                                <p class="mb-0 d-flex">
                                    <a href="{{ route('bankgroup-view', ['id' => $group_default->id]) }}">
                                        <strong class="text-primary mr-2">{{ $group_default->name }}</strong> 
                                        <strong><i class="far fa-edit text-primary" style="margin-top: -8px;" title="รายละเอียดกลุ่มธนาคาร {{ $group_default->name }}"></i></strong>
                                    </a>
                                    <small class="ml-2">
                                        <span class="badge badge-primary font-weight-normal">ค่าเริ่มต้น</span>
                                    </small>
                                </p>
                                <small class="fs--11">จำนวนบัญชีที่อยู่ในกลุ่ม <strong>{{ $group_default->banks_count }}</strong> บัญชี</small>
                            </td>

                            <td class="text-center">
                                <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                            </td>

                            <td class="text-center">
                                <a class="text-truncate mr-2" href="#!" title="แก้ไข" data-toggle="modal" data-target="#bankGroupEditModal" 
                                    onClick="setBankGroupDataEdit('{{ $group_default->id }}', '{{ $group_default->name }}', '{{ $group_default->isactive }}', '{{ $group_default->isdefault }}')">
                                    <i class="fi fi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @endif
                    <!-- END Default Bank Group -->

                    @foreach($bank_groups as $key => $bgroup)
                        <tr id="message_id_{{ $key }}" class="text-dark">

                            <td class="text-center">
                                <small>{{ $key + 1 }}.</small>
                            </td>

                            <td style="line-height: 17px;">
                                <p class="mb-0 d-flex">
                                    <a href="{{ route('bankgroup-view', ['id' => $bgroup->id]) }}">
                                        <strong class="text-dark mr-2">{{ $bgroup->name }}</strong> 
                                        <strong><i class="far fa-edit text-primary" style="margin-top: -8px;" title="รายละเอียดกลุ่มธนาคาร {{ $bgroup->name }}"></i></strong>
                                    </a>
                                </p>
                                <small class="fs--11">จำนวนบัญชีที่อยู่ในกลุ่ม <strong>{{ $bgroup->banks_count }}</strong> บัญชี</small>
                            </td>

                            <td class="text-center">
                                @if($bgroup->isactive == 'Y')
                                    <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                @else
                                    <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a class="text-truncate mr-2" href="#!" title="แก้ไข" data-toggle="modal" data-target="#bankGroupEditModal" 
                                    onClick="setBankGroupDataEdit('{{ $bgroup->id }}', '{{ $bgroup->name }}', '{{ $bgroup->isactive }}', '{{ $bgroup->isdefault }}')">
                                    <i class="fi fi-pencil"></i>
                                </a>

                                <a class="text-truncate mr-2" href="/settings/bank-groups/active/{{ $bgroup->id }}">
                                    @if($bgroup->isactive == 'Y')
                                        <span class="text-success" title="ปิดการใช้งาน"><i class="fi fi-eye"></i></span>
                                    @else
                                        <span class="text-danger" title="เปิดการใช้งาน"><i class="fi fi-eye-disabled"></i></span>
                                    @endif
                                </a>

                                <a  href="#!" 
                                    class="text-truncate js-ajax-confirm" 
                                    data-href="/settings/bank-groups/delete/{{ $bgroup->id }}"
                                    data-ajax-confirm-body="ยืนยันการลบบัญชีธนาคาร {{ $bgroup->name }} ?" 

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
                            <th>กลุ่มธนาคาร</th>
                            <th class="text-center">สถานะ</th>
                            <th class="w--150 text-center"></th>
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
    @include('bankgroups.modal.create')
    @include('bankgroups.modal.edit')
@endsection