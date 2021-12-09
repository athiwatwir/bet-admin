@extends('layouts.core')

@section('title', 'จัดการตำแหน่งผู้ดูแลระบบ')

@section('content')
<div class="row gutters-sm">

    <!-- inbox list -->
    <div class="col-12 col-lg-12 col-xl-12">


        <!-- portlet -->
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">

                    <a href="{{ route('role-create') }}" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3">
                        + เพิ่มตำแหน่ง
                    </a>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    ผู้ดูแลระบบทั้งหมด
                </span>
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-2 px-5">

                <table class="table-datatable table table-bordered table-hover table-striped px-3"
                    data-lng-empty="ไม่มีข้อมูล..." 
                    data-lng-page-info="แสดงผลผู้ดูแลระบบที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ ผู้ดูแลระบบ" 
                    data-lng-filtered="(filtered from _MAX_ total entries)" 
                    data-lng-loading="กำลังโหลด..." 
                    data-lng-processing="กำลังดำเนินการ..." 
                    data-lng-search="ค้นหาผู้ดูแลระบบ..." 
                    data-lng-norecords="ไม่มีผู้ดูแลระบบที่ค้นหา..." 
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
                            <th>ตำแหน่ง</th>
                            <th class="w--150 text-center">สถานะ</th>
                            <th class="w--150 text-center">จัดการ</th>
                        </tr>
                    </thead>

                    <tbody id="item_list">
                    @foreach ($roles as $key => $role)
                        <!-- admin -->
                        <tr class="text-dark">

                            <td>
                                @if($role->isactive == 'EX')
                                    <strong class="text-primary">{{ $role->name }}</strong>
                                @else
                                    <span class="text-dark">{{ $role->name }}</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if($role->isactive == 'EX')
                                    <span class="badge badge-primary font-weight-normal mt-1">ผู้ควบคุมหลัก</span>
                                @elseif($role->isactive == 'Y')
                                    <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                @else
                                    <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a class="text-truncate mr-2" href="#!">
                                    <i class="fas fa-file-alt"></i>
                                </a>
                                <a class="text-truncate mr-2 text-success" href="{{ route('role-edit', ['id' => $role->id]) }}" title="แก้ไข">
                                    <i class="fi fi-pencil"></i>
                                </a>

                                @if($role->isactive != 'EX')
                                <a href="{{ route('role-active', ['id' => $role->id]) }}" class="text-truncate mr-2 text-success" title="เปลี่ยนแปลงสถานะ" onclick="return confirm('เปลี่ยนแปลงสถานะ')">
                                    @if($role->isactive == 'Y')
                                        <i class="fas fa-eye text-dark"></i>
                                    @elseif($role->isactive == 'N')
                                        <i class="fas fa-eye-slash text-dark"></i>
                                    @endif
                                </a>
                                <a	href="#!" 
                                    class="js-ajax-confirm text-danger" 
                                    data-href="{{ route('role-delete', ['id' => $role->id]) }}"
                                    data-ajax-confirm-body="<center>
                                                                <h4 class='mb-2'>ยืนยันการลบตำแหน่งผู้ดูแลระบบ ? </h4>
                                                                {{ $role->name }}
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
                                @endif
                            </td>

                        </tr>
                        <!-- /admin -->
                    @endforeach
                    </tbody>
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