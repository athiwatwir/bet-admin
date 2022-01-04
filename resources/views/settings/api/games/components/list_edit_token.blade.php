<table class="table-datatable table table-bordered table-hover table-striped px-3 pb-2"
    data-lng-empty="ไม่มีข้อมูล..." 
    data-lng-page-info="แสดงผล Token Key ที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ Token Key" 
    data-lng-filtered="(filtered from _MAX_ total entries)" 
    data-lng-loading="กำลังโหลด..." 
    data-lng-processing="กำลังดำเนินการ..." 
    data-lng-search="ค้นหารายการ..." 
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
    <strong class="text-dark float-left">รายการ Token Key</strong>
    <button type="button" id="edit-api-token" class="btn btn-vv-sm btn-warning float-right fs--14 mx-1"><i class="fas fa-edit"></i> แก้ไขรายการ</button>
    <button type="button" id="cancel-api-token" class="btn btn-vv-sm btn-secondary float-right fs--14 mx-1" style="display: none;"><i class="fas fa-times"></i> ยกเลิก</button>
    <button type="button" id="add-api-token" class="btn btn-vv-sm btn-primary float-right fs--14 mx-1"><i class="fas fa-plus"></i> เพิ่มรายการ</button>
    <button type="submit" id="save-api-token" class="btn btn-vv-sm btn-success float-right fs--14 mx-1" style="display: none;"><i class="fas fa-save"></i> บันทึกการแก้ไข</button>
    <thead>
        <tr class="text-muted fs--13">
            <th style="width: 250px;">ชื่อ Token Key</th>
            <th>Token Key</th>
        </tr>
    </thead>

    <tbody id="item_list">
    @foreach($game->api_token as $key => $token)
        <!-- admin -->
        <tr class="text-dark">

            <td class="p-0 td-list-item">
                <input placeholder="ชื่อ Token Key" name="token[{{ $key }}][name]" type="text" class="custom-form-control setting-form-control is-api_token_name" value="{{ $token->name }}" disabled autocomplete="off">
            </td>

            <td class="p-0 td-list-item">
                <input placeholder="Token Key" name="token[{{ $key }}][value]" type="text" class="custom-form-control setting-form-control is-api_token_key" value="{{ $token->value }}" disabled autocomplete="off">
                <input type="hidden" name="token[{{ $key }}][id]" value="{{ $token->id }}">
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
    select.custom-select.custom-select-sm.form-control.form-control-sm {
        display: none;
    }
    .custom-form-control {
        border: none;
        background: transparent;
    }
    .setting-form-control {
        padding: 0 15px;
        height: 40px;
        width: 100%;
        border-color: #ccc;
        border-top: none;
        border-right: none;
        border-left: none;
        border-radius: 0;
        background-color: transparent;
    }
    .td-list-item {
        padding: 0 5px !important;
    }
</style>

<script>
    const EDIT_TOKEN_BTN = document.querySelector('#edit-api-token')
    const CANCEL_TOKEN_BTN = document.querySelector('#cancel-api-token')
    const SAVE_TOKEN_BTN = document.querySelector('#save-api-token')
    const ADD_TOKEN_BTN = document.querySelector('#add-api-token')

    EDIT_TOKEN_BTN.addEventListener('click', () => {
        this.setConfigAttribute(document.querySelectorAll('input.is-api_token_name'))
        this.setConfigAttribute(document.querySelectorAll('input.is-api_token_key'))
        this.setAttributeApiTokenBtn('none', 'initial')
    })

    CANCEL_TOKEN_BTN.addEventListener('click', () => {
        this.cancelConfigAttribute(document.querySelectorAll('input.is-api_token_name'))
        this.cancelConfigAttribute(document.querySelectorAll('input.is-api_token_key'))
        this.setAttributeApiTokenBtn('initial', 'none')
    })

    function setConfigAttribute(data) {
        data.forEach((key) => {
            key.classList.remove('custom-form-control')
            key.classList.add('form-control')
            key.removeAttribute('disabled')
        })
    }

    function cancelConfigAttribute(data) {
        data.forEach((key) => {
            key.classList.remove('form-control')
            key.classList.add('custom-form-control')
            key.setAttribute('disabled', 'true')
        })
    }

    function setAttributeApiTokenBtn(display1, display2) {
        ADD_TOKEN_BTN.style.display = display1
        EDIT_TOKEN_BTN.style.display = display1
        
        CANCEL_TOKEN_BTN.style.display = display2
        SAVE_TOKEN_BTN.style.display = display2
    }
</script>