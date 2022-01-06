<table class="table-datatable table table-hover px-3 pb-2"
    data-lng-empty="ไม่มีข้อมูล..." 
    data-lng-page-info="แสดงผล API URL ที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ API URL" 
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
    <strong class="text-dark float-left">รายการ API URL</strong> <small id="editing-config" class="text-danger ml-2"></small>
    <button type="button" id="edit-config" class="btn btn-vv-sm btn-warning float-right fs--14 mx-1"><i class="fas fa-edit"></i> แก้ไขรายการ</button>
    <button type="button" id="cancel-config" class="btn btn-vv-sm btn-secondary float-right fs--14 mx-1" style="display: none;"><i class="fas fa-times"></i> ยกเลิก</button>
    <button type="button" id="add-config" class="btn btn-vv-sm btn-primary float-right fs--14 mx-1"><i class="fas fa-plus"></i> เพิ่มรายการ</button>
    <button type="submit" id="save-config" class="btn btn-vv-sm btn-success float-right fs--14 mx-1" style="display: none;"><i class="fas fa-save"></i> บันทึกการแก้ไข</button>
    <thead>
        <tr class="text-muted fs--13">
            <th style="width: 250px;">รายการ</th>
            <th class="text-center">Method</th>
            <th>API URL</th>
        </tr>
    </thead>

    <tbody id="item_list_config">
    @foreach($game->api_config as $key => $config)
        <!-- admin -->
        <tr id="tr-form" class="text-dark">

            <td class="p-0 td-list-item">
                <input id="key_name-{{ $key }}" name="config[{{ $key }}][key_name]" class="custom-form-control setting-form-control is-key_name" disabled value="{{ $config->key_name }}" autocomplete="off">
            </td>

            <td class="text-center p-0 td-list-item">
                <select id="method-{{ $key }}" name="config[{{ $key }}][method]" class="custom-form-control setting-form-control text-center is-method" disabled>
                    <option value="POST" @if($config->method == 'POST') selected @endif>POST</option>
                    <option value="GET" @if($config->method == 'GET') selected @endif>GET</option> 
                </select>
            </td>

            <td class="p-0 td-list-item">
                <input id="parameter-{{ $key }}" name="config[{{ $key }}][parameter]" class="custom-form-control setting-form-control is-parameter" disabled value="{{ $config->value }}" autocomplete="off">
                <input type="hidden" name="config[{{ $key }}][id]" value="{{ $config->id }}">
            </td>
        </tr>
        <!-- /admin -->
    @endforeach
    </tbody>
</table>

<script>
    const INPUT_ID = ['key_name', 'parameter', 'method']
    const EDIT_BTN = document.querySelector('#edit-config')
    const EDIT_BTN_CANCEL = document.querySelector('#cancel-config')
    const SAVE_BTN = document.querySelector('#save-config')
    const ADD_BTN = document.querySelector('#add-config')
    const EDITTING_CONFIG = document.querySelector('#editing-config')
    const CARD_CONFIG = document.querySelector('#card-config')
    let key_config = 1

    EDIT_BTN.addEventListener('click', () => {
        this.setConfigAttribute(document.querySelectorAll('input.is-key_name'))
        this.setConfigAttribute(document.querySelectorAll('select.is-method'))
        this.setConfigAttribute(document.querySelectorAll('input.is-parameter'))
        this.setAttributeConfigBtn('none', 'initial')
        CARD_CONFIG.classList.add('border-warning')
        CARD_CONFIG.classList.remove('border-secondary')
        EDITTING_CONFIG.innerHTML = '( <i class="fi fi-circle-spin fi-spin text-dark"></i> กำลังแก้ไข... )'
    })

    EDIT_BTN_CANCEL.addEventListener('click', () => {
        this.cancelConfigAttribute(document.querySelectorAll('input.is-key_name'))
        this.cancelConfigAttribute(document.querySelectorAll('select.is-method'))
        this.cancelConfigAttribute(document.querySelectorAll('input.is-parameter'))
        this.setAttributeConfigBtn('initial', 'none')
        CARD_CONFIG.classList.add('border-secondary')
        CARD_CONFIG.classList.remove('border-warning')
        EDITTING_CONFIG.innerHTML = ''
    })

    ADD_BTN.addEventListener('click', () => {
        let form = document.querySelector('#item_list_config')

        let TR = document.createElement('tr')
        TR.setAttribute('class', 'text-dark')

        let TD_1 = document.createElement('td')
        TD_1.setAttribute('class', 'p-0 td-list-item')

        let API_NAME = document.createElement('input')
        API_NAME.setAttribute('type', 'text')
        API_NAME.setAttribute('placeholder', 'รายการ')
        API_NAME.setAttribute('name', 'config['+key_config+'][key_name]')
        API_NAME.setAttribute('required', 'true')
        API_NAME.setAttribute('class', 'form-control setting-form-control')
        API_NAME.setAttribute('autocomplete', 'off')

        let TD_2 = document.createElement('td')
        TD_2.setAttribute('class', 'text-center p-0 td-list-item')

        let SELECT = document.createElement("select")
        SELECT.setAttribute("class", "form-control setting-form-control text-center")
        SELECT.setAttribute("id", "method")
        SELECT.setAttribute("name", "config["+key_config+"][method]")

        let OPTION_1 = document.createElement("option")
        OPTION_1.setAttribute("value", "POST")
        OPTION_1.innerText = "POST"

        let OPTION_2 = document.createElement("option")
        OPTION_2.setAttribute("value", "GET")
        OPTION_2.innerText = "GET"

        let TD_3 = document.createElement('td')
        TD_3.setAttribute('class', 'p-0 td-list-item')

        let API_URL = document.createElement('input')
        API_URL.setAttribute('type', 'text')
        API_URL.setAttribute('placeholder', 'API URL')
        API_URL.setAttribute('name', 'config['+key_config+'][value]')
        API_URL.setAttribute('required', 'true')
        API_URL.setAttribute('class', 'form-control setting-form-control')
        API_URL.setAttribute('autocomplete', 'off')

        form.prepend(TR)
        TR.append(TD_1)
        TD_1.append(API_NAME)

        TR.append(TD_2)
        TD_2.append(SELECT)
        SELECT.append(OPTION_1)
        SELECT.append(OPTION_2)

        TR.append(TD_3)
        TD_3.append(API_URL)

        key_config++
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

    function setAttributeConfigBtn(display1, display2) {
        ADD_BTN.style.display = display1
        EDIT_BTN.style.display = display1
        
        EDIT_BTN_CANCEL.style.display = display2
        SAVE_BTN.style.display = display2
    }
</script>