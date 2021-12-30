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
            <th>รายการ</th>
            <th class="text-center">Method</th>
            <th>พารามิเตอร์</th>
            <th class="w--150 text-center">แก้ไข</th>
        </tr>
    </thead>

    <tbody id="item_list">
    @foreach($game->api_config as $key => $config)
        <!-- admin -->
        <tr class="text-dark">

            <td class="p-0">
                <input id="key_name-{{ $key }}" class="custom-form-control setting-form-control" disabled value="{{ $config->key_name }}">
            </td>

            <td class="text-center p-0">
                <select id="method-{{ $key }}" class="custom-form-control setting-form-control" disabled>
                    <option value="POST" @if($config->method == 'POST') selected @endif>POST</option>
                    <option value="GET" @if($config->method == 'GET') selected @endif>GET</option> 
                </select>
            </td>

            <td class="p-0">
                <input id="parameter-{{ $key }}" class="custom-form-control setting-form-control" disabled value="{{ $config->value }}">
            </td>

            <td class="text-center p-0">
                <button type="button" id="edit_btn-{{ $key }}" class="btn btn-vv-sm btn-link text-success" title="แก้ไข" onClick="setConfigEditBtn({{ $key }})">
                    <i class="fi fi-pencil"></i>
                </button>
                <button type="button" id="cancel_btn-{{ $key }}" class="btn btn-vv-sm btn-link text-danger" style="display: none;" title="ยกเลิก" onClick="setConfigCancelBtn({{ $key }})">
                    X
                </button>
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
    }
</style>

<script>
    function setConfigAttribute(id, index){
        let CONFIG = document.querySelector('#'+id+'-'+index)
        CONFIG.classList.remove('custom-form-control')
        CONFIG.classList.add('form-control')
        CONFIG.removeAttribute('disabled')
    }

    function cancelConfigAttribute(id, index){
        let CONFIG = document.querySelector('#'+id+'-'+index)
        CONFIG.classList.remove('form-control')
        CONFIG.classList.add('custom-form-control')
        CONFIG.setAttribute('disabled', 'true')
    }

    function setConfigEditBtn(index) {
        this.setConfigAttribute('key_name', index)
        this.setConfigAttribute('parameter', index)
        this.setConfigAttribute('method', index)
        let BTN_EDIT = document.querySelector('#edit_btn-'+index)
        let BTN_CANCEL = document.querySelector('#cancel_btn-'+index)
        BTN_EDIT.style.display = 'none'
        BTN_CANCEL.style.display = 'initial'
    }

    function setConfigCancelBtn(index) {
        this.cancelConfigAttribute('key_name', index)
        this.cancelConfigAttribute('parameter', index)
        this.cancelConfigAttribute('method', index)
        let BTN_EDIT = document.querySelector('#edit_btn-'+index)
        let BTN_CANCEL = document.querySelector('#cancel_btn-'+index)
        BTN_EDIT.style.display = 'initial'
        BTN_CANCEL.style.display = 'none'
    }
</script>