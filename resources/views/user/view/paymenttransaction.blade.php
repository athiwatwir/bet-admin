<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

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
                            <th>ประเภทรายการ</th>
                            <th class="text-center">วัน-เวลา</th>
                            <th class="text-center">ไปยังบัญชี</th>
                            <th class="text-center">จำนวนเงิน</th>
                            <th class="text-center">สลิป</th>
                            <th class="text-center">สถานะ</th>
                        </tr>
                    </thead>

                    <tbody id="item_list">
                    @foreach ($transaction as $key => $trans)

                        <tr id="message_id_{{ $key }}" class="text-dark 
                                                        @if($trans->code == 'DEPOSIT') bg-deposit 
                                                        @elseif($trans->code == 'WITHDRAW') bg-withdraw  
                                                        @elseif($trans->code == 'TRANSFER') bg-transfer
                                                        @elseif($trans->code == 'ADJUST') bg-increase
                                                        @endif ">

                            <td style="line-height: 17px;">
                                <p class="mb-0">
                                    <span class="badge 
                                                @if($trans->code == 'DEPOSIT') badge-success 
                                                @elseif($trans->code == 'WITHDRAW') badge-danger 
                                                @elseif($trans->code == 'TRANSFER') badge-warning
                                                @elseif($trans->code == 'ADJUST') badge-primary
                                                @endif 
                                                font-weight-normal fs--16"
                                    >{{ $trans->code }}
                                    </span>
                                </p>
                                @if(isset($trans->description))
                                    <small><small><span class="text-danger">**</span> {{ $trans->description }}</small></small>
                                @endif
                            </td>

                            <td class="text-center" style="line-height: 17px;">
                                {{ date('d-m-Y', strtotime($trans->action_date)) }}<br/>
                                <small>{{ date('H:i:s', strtotime($trans->action_date)) }}</small>
                            </td>

                            <td class="text-center" style="line-height: 16px;">
                                @if(isset($trans->by_admin))
                                    <small>
                                        <strong>ผู้ดูแลระบบ : {{ $trans->by_admin }}</strong>
                                    </small><br/>
                                    <small><i class="fi fi-arrow-down-full text-primary"></i></small></br>
                                    <small>
                                        @if($trans->to_default == 'Y')
                                            กระเป๋าหลัก
                                        @else
                                            กระเป๋าเกม : {{ $trans->to_game }}
                                        @endif
                                    </small>
                                @else
                                    @if($trans->code == 'DEPOSIT')
                                        {{ $trans->cbank_name }}<br/>
                                        <small>{{ $trans->account_name }}</small><br/>
                                        <small>{{ $trans->account_number }}</small>
                                    @elseif($trans->code == 'WITHDRAW')
                                        {{ $trans->ubank_name }}<br/>
                                        <small>{{ $trans->bank_account_name }}</small><br/>
                                        <small>{{ $trans->bank_account_number }}</small>
                                    @elseif($trans->code == 'TRANSFER')
                                        <small>
                                            @if($trans->from_default == 'Y')
                                                กระเป๋าหลัก
                                            @else
                                                กระเป๋าเกม : {{ $trans->from_game }}
                                            @endif
                                        </small><br/>
                                        <small><i class="fi fi-arrow-down-full text-primary"></i></small></br>
                                        <small>
                                            @if($trans->to_default == 'Y')
                                                กระเป๋าหลัก
                                            @else
                                                กระเป๋าเกม : {{ $trans->to_game }}
                                            @endif
                                        </small>
                                    @endif
                                @endif
                            </td>

                            <td class="text-center">
                                <strong class=" @if($trans->code == 'DEPOSIT') text-success 
                                            @elseif($trans->code == 'WITHDRAW') text-danger 
                                            @elseif($trans->code == 'TRANSFER') text-warning
                                            @endif "
                                >
                                @if($trans->code == 'ADJUST')
                                    @if($trans->code_status == 'Plus')
                                        <span class="text-success">+ {{ number_format($trans->amount) }}</span>
                                    @elseif($trans->code_status == 'Minus')
                                        <span class="text-danger">- {{ number_format($trans->amount) }}</span>
                                    @else
                                        <span class="text-dark">{{ number_format($trans->amount) }}</span>
                                    @endif
                                @else
                                    {{ number_format($trans->amount) }}
                                @endif
                                </strong>
                            </td>

                            <td class="text-center">
                                @if(isset($trans->slip))
                                    <a href="#!" title="ดูสลิปโอนเงิน" 
                                        data-toggle="modal" data-target="#paymentSlipModal" 
                                        onClick="setImagePaymentTransactionSlip(
                                            '{{ $trans->slip }}', '{{ $trans->from_bank_nane }}', '{{ $trans->from_bank_name_en }}', 
                                            '{{ $trans->from_account_name }}', '{{ $trans->from_account_number }}', 
                                            '{{ $trans->payment_date }}', '{{ $trans->payment_time }}')">
                                        <i class="fi fi-image"></i>
                                    </a>
                                @endif
                            </td>

                            <td class="text-center">
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
                        <tr class="text-muted fs--13">
                            <th>ประเภทรายการ</th>
                            <th class="text-center">วัน-เวลา</th>
                            <th class="text-center">ไปยังบัญชี</th>
                            <th class="text-center">จำนวนเงิน</th>
                            <th class="text-center">สลิป</th>
                            <th class="text-center">สถานะ</th>
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