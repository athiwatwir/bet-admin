<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table-datatable table table-bordered table-hover table-striped"
                    data-lng-empty="ไม่มีข้อมูล..." 
                    data-lng-page-info="แสดงผลที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ" 
                    data-lng-filtered="(filtered from _MAX_ total entries)" 
                    data-lng-loading="กำลังโหลด..." 
                    data-lng-processing="กำลังดำเนินการ..." 
                    data-lng-search="ค้นหา..." 
                    data-lng-norecords="ไม่มีรายการที่ค้นหา..." 
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
                            <th>รายการกระเป๋า</th>
                            <th class="text-center">จำนวนเงิน</th>
                            <th class="text-right">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody id="item_list">
                        <tr class="bg-light">
                            <td>
                                <p class="mb-0 d-flex">
                                    <strong class="text-dark">กระเป๋าเงินหลัก</strong>
                                </p>
                            </td>
                            
                            <td class="text-center">
                                <strong class="text-success">{{ number_format($default_wallet->amount) }}</strong> <small><small>{{ $default_wallet->currency }}</small></small>
                            </td>
                            <td class="text-center">
                                <div class="flex text-right">
                                    <a class="ml-2 mr-4" href="#!" title="เพิ่มเงินในกระเป๋าหลัก" 
                                        data-toggle="modal" data-target="#increaseWalletModal" 
                                        onClick="setDataIncreaseWalletAmount(
                                            '{{ $default_wallet->id }}', {{ $default_wallet->amount }}, 'หลัก', 
                                            '{{ $username }}', {{ $user_level->limit_deposit }}
                                        )"
                                    >
                                        <i class="fi fi-plus mr-0 text-primary"></i>
                                    </a>
                                    <a href="#!" title="ลดเงินในกระเป๋าหลัก" 
                                        data-toggle="modal" data-target="#decreaseWalletModal" 
                                        onClick="setDataDecreaseWalletAmount(
                                            '{{ $default_wallet->id }}', {{ $default_wallet->amount }} , 'หลัก', 
                                            '{{ $username }}', {{ $user_level->limit_withdraw }}
                                        )"
                                    >
                                        <i class="fi fi-minus mr-0 text-danger"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        @foreach($wallets as $key => $is_wallet)
                        <tr class="text-dark">
                            <td>
                                <p class="mb-0 d-flex">
                                    กระเป๋าเงินเกม : {{ $is_wallet->game_name }}
                                </p>

                                <!-- MOBILE ONLY -->
                                <div class="fs--13 d-block d-xl-none">
                                    <strong class="text-success">{{ number_format($is_wallet->amount) }}</strong> <small>{{ $is_wallet->currency }}</small>
                                </div>
                                <!-- /MOBILE ONLY -->
                            </td>

                            <td class="text-center">
                                <strong class="text-success">
                                    @if($is_wallet->game_name == 'PG Softgame')
                                        {{ number_format($pg_wallet, 1) }}
                                    @endif
                                </strong> <small>{{ $is_wallet->currency }}</small>
                            </td>

                            <td class="text-right">
                                <button data-toggle="modal" data-target="#pgsoftPlayingSummaryModal" class="btn btn-vv-sm btn-secondary">รายละเอียดการเล่นเกม</button>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="text-muted fs--13">
                            <th>รายการกระเป๋า</th>
                            <th class="text-center">จำนวนเงิน</th>
                            <th class="text-right">การจัดการ</th>
                        </tr>
                    </tfoot>
                </table>

            </div>

        </div>


    </div>

</div>