<section>
    <table class="table-datatable table table-bordered table-hover table-striped"
        data-lng-page-info="แสดงผลข้อมูลที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ ข้อมูล" 
        data-lng-loading="กำลังโหลด..." 
        data-lng-processing="กำลังดำเนินการ..." 
        data-lng-search="ค้นหาสมาชิก..." 
        data-lng-norecords="ไม่มีข้อมูลที่ค้นหา..." 

        data-main-search="true" 
        data-column-search="false" 
        data-row-reorder="false" 
        data-col-reorder="false" 
        data-responsive="false" 
        data-header-fixed="false" 
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
                <th>ชื่อผู้ใช้</th>
                <th>ชื่อ</th>
                <th class="text-center">โทรศัพท์</th>
                <th class="text-center">ไลน์</th>
                <th class="text-center">เงินในกระเป๋า</th>
                <th>เพิ่มเงิน / ลดเงิน</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $key => $user)
            <tr>
                <td>
                    <small>{{ $user->username }}</small>
                </td>
                <td>
                    <small>{{ $user->name }}</small>
                </td>
                <td class="text-center">
                    <small>{{ $user->phone }}</small>
                </td>
                <td class="text-center">
                    <small>{{ $user->line }}</small>
                </td>
                <td class="text-center">
                    <small>{{ number_format($user->wallet_amount) }}</small>
                </td>
                <td class="text-center">
                    <a class="ml-2 mr-3 float-start" href="#!" title="เพิ่มเงินในกระเป๋าหลัก" 
                        data-toggle="modal" data-target="#increaseWalletModal" 
                        onClick="setDataIncreaseWalletAmount(
                            '{{ $user->wallet_id }}', {{ $user->wallet_amount }}, 'หลัก', 
                            '{{ $user->username }}', {{ $user->limit_deposit }}
                        )"
                    >
                        <i class="fi fi-plus mr-0 text-primary"></i>
                    </a>
                    
                    <a href="#!" title="ลดเงินในกระเป๋าหลัก" 
                        data-toggle="modal" data-target="#decreaseWalletModal" 
                        onClick="setDataDecreaseWalletAmount(
                            '{{ $user->wallet_id }}', {{ $user->wallet_amount }}, 'หลัก', 
                            '{{ $user->username }}', {{ $user->limit_withdraw }}
                        )"
                    >
                        <i class="fi fi-minus mr-0 text-danger"></i>
                    </a>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="text-muted fs--13">
                <th>ชื่อผู้ใช้</th>
                <th>ชื่อ</th>
                <th class="text-center">โทรศัพท์</th>
                <th class="text-center">ไลน์</th>
                <th class="text-center">เงินในกระเป๋า</th>
                <th>เพิ่มเงิน / ลดเงิน</th>
            </tr>
        </tfoot>
    </table>
</section>

<style>
    select.custom-select.custom-select-sm.form-control.form-control-sm, .dt-buttons.btn-group.flex-wrap {
        display: none;
    }
</style>