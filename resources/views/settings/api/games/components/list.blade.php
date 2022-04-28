<table class="table-datatable table table-bordered table-hover table-striped px-3"
    data-lng-empty="ไม่มีข้อมูล..." 
    data-lng-page-info="แสดงผลเกมที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ เกม" 
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
            <th>เกม</th>
            <th class="text-center">จำนวนกระเป๋าเกม</th>
            <th class="w--150 text-center">สถานะ</th>
            <th class="w--150 text-center">จัดการ</th>
        </tr>
    </thead>

    <tbody id="item_list">
    @foreach ($games as $key => $game)
        <!-- admin -->
        <tr class="text-dark">

            <td class="d-flex" style="line-height: 17px;">
                <img src="{{ Request::root() }}/logogames/{{ $game->logo }}" style="width: 60px;">
                <div class="ml-3">
                    <span class="text-dark">{{ $game->name }}</span><br/>
                    <small class="text-secondary fs--11">รหัสเกม : {{ $game->gamecode }}</small>
                </div>
            </td>
            
            <td class="text-center">
                @if($game->wallet_count <= 0)
                    <small class="text-secondary">ยังไม่มีกระเป๋าเงิน</small>
                @else
                    {{ $game->wallet_count }}
                @endif
            </td>

            <td class="text-center">
                @if($game->isactive == 'Y')
                    <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                @else
                    <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                @endif
            </td>

            <td class="text-center">
                <a class="text-truncate mr-2 text-primary" href="{{ route('setting-api-game-edit', ['id' => $game->id]) }}" title="แก้ไข">
                    <i class="fi fi-pencil"></i>
                </a>

                <a href="{{ route('setting-api-game-active', ['id' => $game->id]) }}" class="text-truncate mr-2 text-success" title="เปลี่ยนแปลงสถานะ" onclick="return confirm('เปลี่ยนแปลงสถานะ')">
                    @if($game->isactive == 'Y')
                        <i class="fas fa-link text-success"></i>
                    @elseif($game->isactive == 'N')
                        <i class="fas fa-unlink text-dark"></i>
                    @endif
                </a>
                <a	href="#!" 
                    class="js-ajax-confirm text-danger" 
                    data-href="{{ route('role-delete', ['id' => $game->id]) }}"
                    data-ajax-confirm-body="<center>
                                                <h4 class='mb-2'>ยืนยันการลบเกม ? </h4>
                                                {{ $game->name }}
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
        <!-- /admin -->
    @endforeach
    </tbody>
</table>

<style>
    .dt-buttons.btn-group.flex-wrap {
        display: none;
    }
    div.dataTables_wrapper div.dataTables_info {
        font-size: 13px;
    }
</style>