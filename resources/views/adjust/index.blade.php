@extends('layouts.core')

@section('title', 'จัดการการปรับเปลี่ยนยอดเงิน')

@section('content')
<div class="row gutters-sm">

    <!-- inbox list -->
    <div class="col-12 col-lg-12 col-xl-12">


        <!-- portlet -->
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    
                </span>
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-2 px-5">

            <table class="table-datatable table table-bordered table-hover table-striped"
                    data-lng-empty="ไม่มีข้อมูล..." 
                    data-lng-page-info="แสดงผลธนาคารที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ ธนาคาร" 
                    data-lng-filtered="(filtered from _MAX_ total entries)" 
                    data-lng-loading="กำลังโหลด..." 
                    data-lng-processing="กำลังดำเนินการ..." 
                    data-lng-search="ค้นหาธนาคาร..." 
                    data-lng-norecords="ไม่มีธนาคารที่ค้นหา..." 
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
                            <th>วัน-เวลา</th>
                            <th>รายละเอียด</th>
                            <th class="text-center">ผู้ดำเนินการ</th>
                            <th class="text-center">จำนวนเงิน</th>
                            <th class="text-center">รอยืนยัน</th>
                        </tr>
                    </thead>

                    <tbody id="item_list">
                    @foreach ($adjusts as $key => $trans)
                        <tr id="message_id_{{ $key }}" class="text-dark bg-increase">

                            <td style="line-height: 17px;">
                                <small>{{ date('d-m-Y', strtotime($trans->action_date)) }}</small> | 
                                <small>{{ date('H:i:s', strtotime($trans->action_date)) }}</small>
                            </td>

                            <td style="line-height: 17px;">
                                @if(isset($trans->description))
                                    <small><span class="text-danger">**</span> {{ $trans->description }}</small>
                                @endif
                            </td>

                            <td class="text-center" style="line-height: 16px;">
                                <small>
                                    <strong>ผู้ดูแลระบบ : <a href="#!">{{ $trans->by_admin }}</a></strong>
                                </small>
                                <small><i class="fi fi-arrow-right-full text-warning"></i></small>
                                <small>
                                    <strong>สมาชิก : <a href="/users/{{ $trans->username }}/{{ $trans->user_id }}/view" target="_blank">{{ $trans->username }}</a></strong>
                                </small>
                            </td>

                            <td class="text-center" style="line-height: 17px;">
                                <strong>
                                    @if($trans->code_status == 'Plus')
                                        <span class="text-success">+ {{ number_format($trans->amount) }}</span>
                                        @if($trans->amount > $trans->limit_deposit)
                                            <br/>
                                            <small class="fs--11 text-danger">เกินวงเงิน : {{ number_format($trans->limit_deposit) }}</small>
                                        @endif
                                    @elseif($trans->code_status == 'Minus')
                                        <span class="text-danger">- {{ number_format($trans->amount) }}</span>
                                        @if($trans->amount > $trans->limit_withdraw)
                                            <br/>
                                            <small class="fs--11 text-danger">เกินวงเงิน : {{ number_format($trans->limit_withdraw) }}</small>
                                        @endif
                                    @endif
                                </strong>
                            </td>

                            <td class="text-center">
                                @if($trans->amount > $trans->limit_deposit || $trans->amount > $trans->limit_withdraw)
                                    @if(session('_p')['position'] == 'Super')
                                        @include('adjust.components.adjust-button')
                                    @else
                                        <small><strong class="text-secondary">ผู้ดูแลระดับ Super เท่านั้น</strong></small>
                                    @endif
                                @else
                                    @include('adjust.components.adjust-button')
                                @endif
                            </td>
                        </tr>
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