@extends('layouts.core')

@section('title', 'การจัดการสมาชิก')

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

                    <a href="#" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3">
                        + เพิ่มสมาชิก
                    </a>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    สมาชิกทั้งหมด
                </span>
            </div>
            <!-- /portlet : header -->

            <!-- portlet : body -->
            <div class="portlet-body pt-3 px-5">

                <table class="table-datatable table table-bordered table-hover table-striped"
                    data-lng-empty="ไม่มีข้อมูล..." 
                    data-lng-page-info="แสดงผลสมาชิกที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ สมาชิก" 
                    data-lng-filtered="(filtered from _MAX_ total entries)" 
                    data-lng-loading="กำลังโหลด..." 
                    data-lng-processing="กำลังดำเนินการ..." 
                    data-lng-search="ค้นหาสมาชิก..." 
                    data-lng-norecords="ไม่มีสมาชิกที่ค้นหา..." 
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
                            <th>ชื่อผู้ใช้</th>
                            <th class="w--250 text-center">โทรศัพท์</th>
                            <th class="w--150 text-center">ไลน์</th>
                            <th class="w--150 text-center">สกุลเงิน</th>
                            <th class="w--150 text-center">กลุ่มลูกค้า</th>
                            <th class="w--150 text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                        <tr class="text-dark">

                            <td class="text-center">
                                <small>{{ $key + 1 }}.</small>
                            </td>

                            <td style="line-height: 17px;">
                                <a class="text-dark" href="/users/{{ $user->username }}/{{ $user->id }}/view" title="ดูรายละเอียดของผู้ใช้งานนี้">
                                    <p class="mb-0 d-flex">
                                        <strong class="text-dark mr-2">{{ $user->username }}</strong> 
                                        <strong><i class="far fa-edit text-primary" style="margin-top: -8px;" title="รายละเอียดสมาชิก {{ $user->username }}"></i></strong>
                                    </p>
                                    <small style="font-size: 70%;">ชื่อ-สกุล : {{ $user->name }}</small>
                                </a>
                            </td>

                            <td class="text-center">
                                {{ $user->phone }}
                            </td>

                            <td class="text-center">
                                @if($user->line != '')
                                    <a href="https://line.me/R/ti/p/{{ $user->line }}" target="_blank">{{ $user->line }}</a>
                                @else
                                    -
                                @endif
                            </td>

                            <td class="text-center">
                                {{ $user->currency }}
                            </td>

                            <td class="text-center">
                                {{ $user->level_name }}
                            </td>

                            <td class="text-center">
                                @if($user->is_active == 'Y')
                                    <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                @else
                                    <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                @endif
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="w--30 text-center">#</th>
                            <th>ชื่อผู้ใช้</span></th>
                            <th class="w--250 text-center">โทรศัพท์</th>
                            <th class="w--150 text-center">ไลน์</th>
                            <th class="w--150 text-center">สกุลเงิน</th>
                            <th class="w--150 text-center">กลุ่มลูกค้า</th>
                            <th class="w--150 text-center">สถานะ</th>
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
    
@endsection