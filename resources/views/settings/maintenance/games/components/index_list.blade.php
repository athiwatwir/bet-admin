<table class="table-datatable table table-bordered table-hover table-striped px-3"
    data-lng-empty="ไม่มีข้อมูล..." 
    data-lng-page-info="แสดงผลรายการที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ" 
    data-lng-filtered="(filtered from _MAX_ total entries)" 
    data-lng-loading="กำลังโหลด..." 
    data-lng-processing="กำลังดำเนินการ..." 
    data-lng-search="ค้นหาเกม..." 
    data-lng-norecords="ไม่มีเกมที่ค้นหา..." 
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
            <th>รายการจาก</th>
            <th class="text-center">ตั้งแต่วันที่</th>
            <th class="w--150 text-center">ถึงวันที่</th>
            <th class="w--150 text-center">จัดการ</th>
        </tr>
    </thead>

    <tbody id="item_list">
    @foreach ($maintenance as $key => $mainten)
        <!-- admin -->
        <tr class="text-dark">

            <td class="d-flex" style="line-height: 17px;">
                {{ $mainten->api_game->name }}
            </td>
            
            <td class="text-center">
                <small>{{ date('d-m-Y', strtotime($mainten->startdate)) }} <br/>
                {{ date('H:i', strtotime($mainten->startdate)) }}</small>
            </td>

            <td class="text-center">
                <small>{{ date('d-m-Y', strtotime($mainten->enddate)) }} <br/>
                {{ date('H:i', strtotime($mainten->enddate)) }}</small>
            </td>

            <td class="text-center">
                @if($mainten->now)
                    <a	href="#!" 
                        class="js-ajax-confirm text-success" 
                        data-href="{{ route('setting-maintenance-game-complete', ['id' => $mainten->id]) }}"
                        data-ajax-confirm-body="<center>
                                                    <h4 class='mb-2'>ปรับปรุงเรียบร้อย ? </h4>
                                                </center>" 

                        data-ajax-confirm-method="GET" 

                        data-ajax-confirm-btn-yes-class="btn-sm btn-success" 
                        data-ajax-confirm-btn-yes-text="ยืนยัน" 
                        data-ajax-confirm-btn-yes-icon="fi fi-check" 

                        data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                        data-ajax-confirm-btn-no-text="ยกเลิก" 
                        data-ajax-confirm-btn-no-icon="fi fi-close">
                        <i class="fi fi-check mr-2"></i>
                    </a>
                @endif

                <a class="text-truncate mr-2 text-primary" href="#" title="แก้ไข">
                    <i class="fi fi-pencil"></i>
                </a>

                @if(!$mainten->now)
                    <a	href="#!" 
                        class="js-ajax-confirm text-danger" 
                        data-href="{{ route('setting-maintenance-game-delete', ['id' => $mainten->id]) }}"
                        data-ajax-confirm-body="<center>
                                                    <h4 class='mb-2'>ยืนยันการลบ ? </h4>
                                                </center>" 

                        data-ajax-confirm-method="GET" 

                        data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                        data-ajax-confirm-btn-yes-text="ลบ" 
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