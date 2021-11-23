@extends('layouts.core')

@section('title', 'การจัดการกลุ่มลูกค้า')

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

                    <a href="message-write.html" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3" data-toggle="modal" data-target="#createUserLevel">
                        + เพิ่มกลุ่มลูกค้า
                    </a>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    กลุ่มลูกค้าทั้งหมด
                </span>
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-2 px-5">

                <table class="table-datatable table table-bordered table-hover table-striped px-3"
                    data-lng-empty="ไม่มีข้อมูล..." 
                    data-lng-page-info="แสดงผลกลุ่มลูกค้าที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ กลุ่ม" 
                    data-lng-filtered="(filtered from _MAX_ total entries)" 
                    data-lng-loading="กำลังโหลด..." 
                    data-lng-processing="กำลังดำเนินการ..." 
                    data-lng-search="ค้นหากลุ่มลูกค้า..." 
                    data-lng-norecords="ไม่มีผู้กลุ่มลูกค้าที่ค้นหา..." 
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
                            <th>กลุ่มลูกค้า</th>
                            <th class="text-center">ยอดฝากสูงสุด</th>
                            <th class="text-center">ยอดถอนสูงสุด</th>
                            <th class="text-center">ยอดโอนสูงสุด</th>
                            <th class="text-center">จำนวนสมาชิกกลุ่ม</th>
                            <th class="text-center">สถานะ</th>
                            <th class="w--150 text-center"></th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($levels as $key => $level)
                        <tr class="text-dark">

                            <td class="text-center">
                                {{ $key + 1 }}.
                            </td>

                            <td style="line-height: 17px;">
                                <span class="@if($level->isdefault == 'Y') text-danger @endif">
                                    {{ $level->name }} @if($level->isdefault == 'Y') <small class="text-dark fs--11">(ค่าเริ่มต้น)</small> @endif
                                </span>
                            </td>

                            <td class="text-center">
                                {{ number_format($level->limit_deposit) }}
                            </td>

                            <td class="text-center">
                                {{ number_format($level->limit_withdraw) }}
                            </td>

                            <td class="text-center">
                                {{ number_format($level->limit_transfer) }}
                            </td>

                            <td class="text-center">
                                {{ $level->users_count }}
                            </td>

                            <td class="text-center">
                                @if($level->isactive == 'Y')
                                    <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                @else
                                    <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a class="text-truncate mr-2" href="#!" title="แก้ไข" data-toggle="modal" data-target="#editUserLevel" onClick="setDataUserLevel('{{$level->id}}', '{{$level->name}}', {{$level->limit_deposit}}, {{$level->limit_withdraw}}, {{$level->limit_transfer}}, '{{$level->isdefault}}')">
                                    <i class="fi fi-pencil"></i>
                                </a>
                                @if($level->isdefault == 'N')
                                    <a class="text-truncate mr-2" href="/user-levels/active/{{ $level->id }}/{{ $level->name }}">
                                        @if($level->isactive == 'Y')
                                            <span class="text-success" title="ปิดการใช้งาน"><i class="fi fi-eye"></i></span>
                                        @else
                                            <span class="text-danger" title="เปิดการใช้งาน"><i class="fi fi-eye-disabled"></i></span>
                                        @endif
                                    </a>
                                
                                    <a  href="#!" 
                                        class="text-truncate js-ajax-confirm" 
                                        data-href="/user-levels/delete/{{ $level->id }}"
                                        data-ajax-confirm-body="<center>ยืนยันการลบกลุ่มลูกค้า {{ $level->name }} ?<br/>
                                                        สมาชิกที่อยู่ในกลุ่มนี้จะถูกย้ายไปยัง กลุ่มค่าเริ่มต้น ทั้งหมด<br/>
                                                        ยืนยันการลบ ?" 

                                        data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                                        data-ajax-confirm-btn-yes-text="ลบข้อมูล" 
                                        data-ajax-confirm-btn-yes-icon="fi fi-check" 

                                        data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                                        data-ajax-confirm-btn-no-text="ยกเลิก" 
                                        data-ajax-confirm-btn-no-icon="fi fi-close">
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
                            <th>กลุ่มลูกค้า</th>
                            <th class="text-center">ยอดฝากสูงสุด</th>
                            <th class="text-center">ยอดถอนสูงสุด</th>
                            <th class="text-center">ยอดโอนสูงสุด</th>
                            <th class="text-center">จำนวนสมาชิกกลุ่ม</th>
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
    @include('userlevel.modal.create_userlevel')
    @include('userlevel.modal.edit_userlevel')
@endsection