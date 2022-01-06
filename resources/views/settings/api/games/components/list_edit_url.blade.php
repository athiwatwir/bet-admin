<form method="POST" action="{{ route('setting-api-game-update-api-domain') }}">
    @csrf
    <table class="table-datatable table table-hover px-3 pb-2"
        data-lng-empty="ไม่มีข้อมูล..." 
        data-lng-page-info="แสดงผล API Domain ที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ API Domain" 
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
        <strong class="text-dark float-left">รายการ API Domain</strong> <small id="editing-api-domain" class="text-danger ml-2"></small>
        <button type="button" id="edit-api-domain" class="btn btn-vv-sm btn-warning float-right fs--14 mx-1"><i class="fas fa-edit"></i> แก้ไขรายการ</button>
        <button type="button" id="cancel-api-domain" class="btn btn-vv-sm btn-secondary float-right fs--14 mx-1" style="display: none;"><i class="fas fa-times"></i> ยกเลิก</button>
        <button type="button" id="add-api-domain" class="btn btn-vv-sm btn-primary float-right fs--14 mx-1"><i class="fas fa-plus"></i> เพิ่มรายการ</button>
        <button type="submit" id="save-api-domain" class="btn btn-vv-sm btn-success float-right fs--14 mx-1" style="display: none;"><i class="fas fa-save"></i> บันทึกการแก้ไข</button>
        <thead>
            <tr class="text-muted fs--13">
                <th style="width: 250px;">ชื่อ API Domain</th>
                <th>API Domain</th>
            </tr>
        </thead>

        <tbody>
        @foreach($game->api_url as $key => $url)
            <!-- admin -->
            <tr class="text-dark">

                <td class="p-0 td-list-item">
                    <input placeholder="ชื่อ API Domain" name="api[{{ $key }}][name]" type="text" class="custom-form-control setting-form-control is-api_domain_name" value="{{ $url->name }}" disabled autocomplete="off">
                </td>

                <td class="p-0 td-list-item">
                    <input placeholder="API Domain" name="api[{{ $key }}][url]" type="text" class="custom-form-control setting-form-control is-api_domain_url" value="{{ $url->url }}" disabled autocomplete="off">
                    <input type="hidden" name="api[{{ $key }}][id]" value="{{ $url->id }}">
                </td>

            </tr>
            <!-- /admin -->
        @endforeach
        </tbody>
    </table>
</form>

<form method="POST" action="{{ route('setting-api-game-add-api-domain') }}">
    @csrf
    <div id="item_list_url"></div>
    <div id="save-btn" class="row py-3 bg-light" style="display: none;">
        <div class="col-12 text-center">
            <button tyle="submit" class="btn btn-vv-sm btn-primary"><i class="fas fa-save"></i> บันทึกรายการ</button>
        </div>
    </div>
    <input type="hidden" name="game_id" value="{{ $game_id }}">
</form>

<script>
    const EDIT_API_DOMAIN_BTN = document.querySelector('#edit-api-domain')
    const CANCEL_API_DOMAIN_BTN = document.querySelector('#cancel-api-domain')
    const SAVE_API_DOMAIN_BTN = document.querySelector('#save-api-domain')
    const ADD_API_DOMAIN_BTN = document.querySelector('#add-api-domain')
    const EDITTING_API_DOMAIN = document.querySelector('#editing-api-domain')
    const CARD_API_DOMAIN = document.querySelector('#card-api-domain')
    let key_api = 1
    let key_count = 0

    EDIT_API_DOMAIN_BTN.addEventListener('click', () => {
        this.setConfigAttribute(document.querySelectorAll('input.is-api_domain_name'))
        this.setConfigAttribute(document.querySelectorAll('input.is-api_domain_url'))
        this.setAttributeApiurlBtn('none', 'initial')
        CARD_API_DOMAIN.classList.add('border-warning')
        CARD_API_DOMAIN.classList.remove('border-secondary')
        EDITTING_API_DOMAIN.innerHTML = '( <i class="fas fa-edit text-dark"></i> แก้ไขรายการ... )'
    })

    CANCEL_API_DOMAIN_BTN.addEventListener('click', () => {
        this.cancelConfigAttribute(document.querySelectorAll('input.is-api_domain_name'))
        this.cancelConfigAttribute(document.querySelectorAll('input.is-api_domain_url'))
        this.setAttributeApiurlBtn('initial', 'none')
        CARD_API_DOMAIN.classList.add('border-secondary')
        CARD_API_DOMAIN.classList.remove('border-warning')
        EDITTING_API_DOMAIN.innerHTML = ''
    })

    ADD_API_DOMAIN_BTN.addEventListener('click', () => {
        let ITEM = document.querySelector('#item_list_url')

        let ROW = document.createElement('div')
        ROW.setAttribute('class', 'row px-3 pt-3 pb-0 bg-light')
        ROW.setAttribute('id', 'row_url-'+key_api)

        let COL_3 = document.createElement('div')
        COL_3.setAttribute('class', 'col-12 col-lg-3')

        let API_NAME = document.createElement('input')
        API_NAME.setAttribute('type', 'text')
        API_NAME.setAttribute('placeholder', 'ชื่อ API Doamin')
        API_NAME.setAttribute('name', 'api['+key_api+'][name]')
        API_NAME.setAttribute('required', 'true')
        API_NAME.setAttribute('class', 'form-control setting-form-control')
        API_NAME.setAttribute('autocomplete', 'off')

        let COL_8 = document.createElement('div')
        COL_8.setAttribute('class', 'col-12 col-lg-8')

        let API_URL = document.createElement('input')
        API_URL.setAttribute('type', 'text')
        API_URL.setAttribute('placeholder', 'API DOMAIN')
        API_URL.setAttribute('name', 'api['+key_api+'][value]')
        API_URL.setAttribute('required', 'true')
        API_URL.setAttribute('class', 'form-control setting-form-control')
        API_URL.setAttribute('autocomplete', 'off')

        let COL_1 = document.createElement('div')
        COL_1.setAttribute('class', 'col-12 col-lg-1 pt-2 pl-0')

        let COL_12 = document.createElement('div')
        COL_12.setAttribute('class', 'col-12 text-center')

        let DELETE = document.createElement('button')
        DELETE.setAttribute('class', 'btn btn-vv-sm btn-danger')
        DELETE.setAttribute('type', 'button')
        DELETE.setAttribute('title', 'ลบรายการที่เลือก')
        DELETE.setAttribute('onClick', 'deleteApiDomain('+ key_api +')')
        DELETE.innerHTML = '<i class="fas fa-times m-0"></i>'

        ITEM.prepend(ROW)

        ROW.append(COL_3)
        COL_3.append(API_NAME)

        ROW.append(COL_8)
        COL_8.append(API_URL)

        ROW.append(COL_1)
        COL_1.append(DELETE)

        key_api++
        this.setKeyCount('add')
    })

    function deleteApiDomain(index) {
        if (confirm('ยืนยัน?')) {
            document.querySelector("#row_url-"+index).remove(index);
            this.setKeyCount('remove')
        }
    }

    function setKeyCount(action) {
        key_count = action === 'add' ? key_count+=1 : key_count-=1
        document.querySelector('#save-btn').style.display = key_count >= 1 ? 'block' : 'none'
    }

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

    function setAttributeApiurlBtn(display1, display2) {
        ADD_API_DOMAIN_BTN.style.display = display1
        EDIT_API_DOMAIN_BTN.style.display = display1
        
        CANCEL_API_DOMAIN_BTN.style.display = display2
        SAVE_API_DOMAIN_BTN.style.display = display2
    }
</script>