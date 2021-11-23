@extends('layouts.core')

@section('title', 'รายการบัญชีธนาคาร')

@section('content')
<div class="row gutters-sm">
    <div class="col-12 col-lg-12 col-xl-12">
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">

                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createCBankModal" style="box-shadow: 2px 2px 4px #aaa;"><i class="fi fi-plus"></i> เพิ่มบัญชีธนาคาร</button>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    
                </span>
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-2 px-5">

                <table class="table-datatable table table-bordered table-hover table-striped"
                    data-lng-empty="ไม่มีข้อมูล..." 
                    data-lng-page-info="แสดงผลบัญชีที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ บัญชี" 
                    data-lng-filtered="(filtered from _MAX_ total entries)" 
                    data-lng-loading="กำลังโหลด..." 
                    data-lng-processing="กำลังดำเนินการ..." 
                    data-lng-search="ค้นหาบัญชี..." 
                    data-lng-norecords="ไม่มีบัญชีที่ค้นหา..." 
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
                            <th>ชื่อธนาคาร</th>
                            <th class="text-center">ชื่อบัญชี</th>
                            <th class="text-center">เลขบัญชี</th>
                            <th class="text-center">สถานะ</th>
                            <th class="w--150">&nbsp;</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($cbanks as $key => $cbank)
                        <tr class="text-dark">

                            <td class="text-center">
                                <small>{{ $key + 1 }}.</small>
                            </td>

                            <td style="line-height: 17px;">
                                <p class="mb-0">
                                    <strong class="text-dark">{{ $cbank->bank_name }}</strong><br/>
                                    <small>{{ $cbank->bank_name_en }}</small>
                                </p>
                            </td>

                            <td class="text-center">
                                {{ $cbank->account_name }}
                            </td>

                            <td class="text-center">
                                {{ $cbank->account_number }}
                            </td>

                            <td class="text-center">
                                @if($cbank->is_active == 'Y') 
                                    <small class="badge badge-success font-weight-normal">เปิดใช้งาน</small>
                                @else 
                                    <small class="badge badge-danger font-weight-normal">ปิดใช้งาน</small>
                                @endif
                            </td>

                            <td class="text-center">

                                <a class="text-truncate mr-1" href="#!" title="แก้ไขบัญชีธนาคาร" 
                                    data-toggle="modal" data-target="#editCBankModal" 
                                    onClick="setDataEditModal('{{ $cbank->id }}', '{{ $cbank->bank_id }}', '{{ $cbank->account_name }}', {{ $cbank->account_number }}, '{{ $cbank->bank_group_id }}')"
                                >
                                    <i class="fi fi-pencil mr-0"></i>
                                </a>

                                <a class="text-truncate mr-1" href="/active-cbank/{{ $cbank->id }}/{{ $cbank->account_name }}/{{ $cbank->account_number }}">
                                    @if($cbank->is_active == 'Y')
                                        <span class="text-success" title="ปิดการใช้งาน"><i class="fi fi-eye"></i></span>
                                    @else
                                        <span class="text-danger" title="เปิดการใช้งาน"><i class="fi fi-eye-disabled"></i></span>
                                    @endif
                                </a>

                                <a	href="#!" 
                                    class="js-ajax-confirm text-danger" 
                                    data-href="/delete-cbank/{{ $cbank->id }}"
                                    data-ajax-confirm-body="<center>
                                                                <h4 class='mb-2'>ยืนยันการลบบัญชีธนาคาร ? </h4>
                                                                {{ $cbank->bank_name }}
                                                                {{ $cbank->account_name }} : {{ $cbank->account_number }}
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

                            </td>

                        </tr>
                    @endforeach
                    </tbody>

                    <tfoot>
                        <tr class="text-muted fs--13">
                            <th class="w--30 text-center">#</th>
                            <th>ชื่อธนาคาร</th>
                            <th class="text-center">ชื่อบัญชี</th>
                            <th class="text-center">เลขบัญชี</th>
                            <th class="text-center">สถานะ</th>
                            <th class="w--150">&nbsp;</th>
                        </tr>
                    </tfoot>

                </table>

            </div>
        </div>
    </div>
</div>
<style>
    .dt-buttons.btn-group.flex-wrap {
        display: none;
    }
</style>
@endsection


@section('modal')
    @include('cbank.modal.add')

    @include('cbank.modal.edit')
@endsection