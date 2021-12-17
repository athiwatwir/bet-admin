<section>
    <table class="table-datatable table table-bordered table-hover table-striped"
        data-lng-empty="ไม่มีข้อมูล..." 
        data-lng-page-info="แสดงผลข้อมูลที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ ข้อมูล" 
        data-lng-filtered="(filtered from _MAX_ total entries)" 
        data-lng-loading="กำลังโหลด..." 
        data-lng-processing="กำลังดำเนินการ..." 
        data-lng-search="ค้นหาข้อมูล..." 
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
                <th class="text-center">รายการของ</th>
                <th class="text-center">วัน-เวลา</th>
                <th class="text-center">ไปยังบัญชี</th>
                <th class="text-center">จำนวนเงิน</th>
                <th class="text-center">สถานะ</th>
                <th>&nbsp;</th>
            </tr>
        </thead>

        <tbody>
        @foreach ($transaction as $key => $trans)
            <tr class="text-dark bg-increase">

                <td style="line-height: 17px;">
                    <p class="mb-0">
                        @if($trans->code_status == 'Promo')
                            <span class="badge badge-pink font-weight-normal fs--12">
                                โปรโมชั่น
                            </span>
                        @else
                            <span class="badge badge-primary font-weight-normal fs--12">
                                ปรับเปลี่ยน
                            </span>
                        @endif
                    </p>
                    @if($trans->code_status != 'Promo')
                        <small class="fs--11"><span class="text-danger">**</span> {{ $trans->description }}</small>
                    @endif
                </td>

                <td class="text-center fs--15" style="line-height: 16px;">
                    @if($trans->code_status == 'Promo')
                        <strong>{{ $trans->description }}</strong>
                    @else
                        <strong>{{ $trans->username }}</strong><br/>
                        <small class="">{{ $trans->name }}</small>
                    @endif
                </td>

                <td class="text-center fs--14" style="line-height: 17px;">
                    <small>{{ date('d-m-Y', strtotime($trans->action_date)) }}</small><br/>
                    <small>{{ date('H:i:s', strtotime($trans->action_date)) }}</small>
                </td>

                <td class="text-center fs--15" style="line-height: 10px;">
                    <small>
                        <strong>ผู้ดูแลระบบ : {{ $trans->by_admin }}</strong>
                    </small><br/>
                    <small><i class="fi fi-arrow-down-full text-primary"></i></small></br>
                    <small>
                        @if($trans->code_status == 'Promo')
                            <a href="#" data-toggle="modal" data-target="#promotionWalletList" onClick="promotionWalletList('{{ $trans->id }}')">
                                <i class="far fa-list-alt"></i> 
                                รายการบัญชี
                            </a>
                        @else
                            @if($trans->to_default == 'Y')
                                กระเป๋าหลัก
                            @else
                                กระเป๋าเกม : {{ $trans->to_game }}
                            @endif
                        @endif
                    </small>
                </td>

                <td class="text-center">
                    <strong>
                        @if($trans->code_status == 'Plus')
                            <span class="text-success">+ {{ number_format($trans->amount) }}</span>
                        @elseif($trans->code_status == 'Minus')
                            <span class="text-danger">- {{ number_format($trans->amount) }}</span>
                        @elseif($trans->code_status == 'Promo')
                            <span class="text-indigo">+ {{ number_format($trans->amount) }}</span>
                        @else
                            <span class="text-dark"># {{ number_format($trans->amount) }}</span>
                        @endif
                    </strong>
                </td>

                <td class="text-center" style="line-height: 14px;">
                    @if($trans->status == 'CO') 
                        <small class="badge badge-success font-weight-normal">ยืนยันแล้ว</small>
                    @elseif($trans->status == 'VO')
                        <small class="badge badge-danger font-weight-normal">ปฏิเสธแล้ว</small>
                    @else
                        <small class="badge badge-secondary font-weight-normal">รอยืนยัน</small>
                    @endif
                    <br/>
                    <small class="fs--11">{{ $trans->admin_confirm }}</small>
                </td>

                <td class="text-align-end">

                    @if($trans->status == NULL)
                        <a href="#!" 
                            class="js-ajax-confirm btn btn-success btn-sm btn-vv-sm ml-0 mb-2 rounded" 
                            data-href="/transaction/confirm-payment-transaction/{{ $trans->id }}"
                            data-ajax-confirm-body="<center>
                                                        <h4 class='mb-2'>ยืนยันการทำรายการ ? </h4>
                                                    </center>" 

                            data-ajax-confirm-method="GET" 

                            data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                            data-ajax-confirm-btn-yes-text="ยืนยัน" 
                            data-ajax-confirm-btn-yes-icon="fi fi-check" 

                            data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                            data-ajax-confirm-btn-no-text="ยกเลิก" 
                            data-ajax-confirm-btn-no-icon="fi fi-close"
                        >
                            ยืนยัน
                        </a>
                        <a href="#!" 
                            class="js-ajax-confirm btn btn-danger btn-sm btn-vv-sm ml-0 mb-2 rounded" 
                            data-href="/transaction/void-payment-transaction/{{ $trans->id }}"
                            data-ajax-confirm-body="<center>
                                                        <h4 class='mb-2'>ยืนยันการทำรายการ ? </h4>
                                                    </center>" 

                            data-ajax-confirm-method="GET" 

                            data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                            data-ajax-confirm-btn-yes-text="ยืนยัน" 
                            data-ajax-confirm-btn-yes-icon="fi fi-check" 

                            data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                            data-ajax-confirm-btn-no-text="ยกเลิก" 
                            data-ajax-confirm-btn-no-icon="fi fi-close"
                        >
                            ปฏิเสธ
                        </a>
                    @endif

                </td>

            </tr>
        @endforeach
        </tbody>

        <tfoot>
            <tr class="text-muted fs--13">
                <th>ประเภทรายการ</th>
                <th class="text-center">รายการของ</th>
                <th class="text-center">วัน-เวลา</th>
                <th class="text-center">ไปยังบัญชี</th>
                <th class="text-center">จำนวนเงิน</th>
                <th class="text-center">สถานะ</th>
                <th>&nbsp;</th>
            </tr>
        </tfoot>
    </table>
</section>

@include('transaction.modal.promotion_wallet_list')