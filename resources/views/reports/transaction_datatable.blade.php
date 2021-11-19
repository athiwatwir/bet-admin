<table class="table-datatable table table-bordered table-hover table-striped"
    data-lng-empty="ไม่มีข้อมูล..." 
    data-lng-page-info="แสดงผลข้อมูลที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ ข้อมูล" 
    data-lng-filtered="(filtered from _MAX_ total entries)" 
    data-lng-loading="กำลังโหลด..." 
    data-lng-processing="กำลังดำเนินการ..." 
    data-lng-search="ค้นหา..." 
    data-lng-norecords="ไม่มีข้อมูลที่ค้นหา..." 
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
    data-select-onclick="true" 
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
        <tr>
            <th>ประเภทรายการ</th>
            <th>รายการของ</th>
            <th class="text-center">วัน-เวลา</th>
            <th>ไปยังบัญชี</th>
            <th class="text-center">จำนวนเงิน</th>
            <th class="text-center">ผู้ทำรายการ</th>
            <th>สถานะ</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $key => $trans)
        <tr>
            <td>
                @if($trans->code == 'DEPOSIT')
                    <small class="badge badge-success font-weight-normal fs--14">เติมเงิน</small>
                @elseif($trans->code == 'WITHDRAW')
                    <small class="badge badge-danger font-weight-normal fs--14">ถอนเงิน</small>
                @elseif($trans->code == 'TRANSFER')
                    <small class="badge badge-warning font-weight-normal fs--14">โอนเงินในระบบ</small>
                @elseif($trans->code == 'ADJUST')
                    <small class="badge badge-primary font-weight-normal fs--14">ปรับเปลี่ยน</small>
                @endif
            </td>
            <td>
                <small>{{ $trans->username }} : {{ $trans->name }}</small>
            </td>
            <td class="text-center">
                <small>{{ date('d-m-Y', strtotime($trans->action_date)) }} | {{ date('H:i:s', strtotime($trans->action_date)) }}</small>
            </td>
            <td>
                @if(isset($trans->by_admin))
                    <small>ผู้ดูแลระบบ : {{ $trans->by_admin }} <span class="text-danger">>></span> @if($trans->to_default == 'Y') กระเป๋าหลัก @else กระเป๋าเกม : {{ $trans->to_game }} @endif</small>
                @else
                    @if($trans->code == 'DEPOSIT')
                        <small>{{ $trans->cbank_name }} : {{ $trans->account_name }} {{ $trans->account_number }}</small>
                    @elseif($trans->code == 'WITHDRAW')
                        <small>{{ $trans->ubank_name }} : {{ $trans->bank_account_name }} {{ $trans->bank_account_number }}</small>
                    @elseif($trans->code == 'TRANSFER')
                        <small>@if($trans->from_default == 'Y') กระเป๋าหลัก @else กระเป๋าเกม : {{ $trans->from_game }} @endif <span class="text-danger">>></span> @if($trans->to_default == 'Y') กระเป๋าหลัก @else กระเป๋าเกม : {{ $trans->to_game }} @endif</small>
                    @endif
                @endif
            </td>
            <td class="text-center">
                {{ number_format($trans->amount) }}
            </td>
            <td class="text-center">
                <small>{{ $trans->staff_username }}</small>
            </td>
            <td>
                @if($trans->status == 'CO') 
                    <small class="badge badge-success font-weight-normal">ยืนยันแล้ว</small>
                @elseif($trans->status == 'VO')
                    <small class="badge badge-danger font-weight-normal">ปฏิเสธแล้ว</small>
                @else
                    <small class="badge badge-secondary font-weight-normal">รอยืนยัน</small>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>ประเภทรายการ</th>
            <th>รายการของ</th>
            <th class="text-center">วัน-เวลา</th>
            <th>ไปยังบัญชี</th>
            <th class="text-center">จำนวนเงิน</th>
            <th class="text-center">ผู้ทำรายการ</th>
            <th>สถานะ</th>
        </tr>
    </tfoot>
</table>