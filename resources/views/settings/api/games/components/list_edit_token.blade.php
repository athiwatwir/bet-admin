<form method="POST" action="{{ route('setting-api-game-update-token') }}">
    @csrf
    <table class="table-datatable table table-hover px-3 pb-2"
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
        <strong class="text-dark float-left">รายการ Token Key</strong> <small id="editing-token" class="text-danger ml-2"></small>
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
</form>


<form method="POST" action="{{ route('setting-api-game-add-api-token') }}">
    @csrf
    <div id="item_list_token"></div>
    <div id="save-btn-token" class="row py-3 bg-light" style="display: none;">
        <div class="col-12 text-center">
            <button tyle="submit" class="btn btn-vv-sm btn-primary"><i class="fas fa-save"></i> บันทึกรายการ</button>
        </div>
    </div>
    <input type="hidden" name="game_id" value="{{ $game_id }}">
</form>


<script>
    const EDIT_TOKEN_BTN = document.querySelector('#edit-api-token')
    const CANCEL_TOKEN_BTN = document.querySelector('#cancel-api-token')
    const SAVE_TOKEN_BTN = document.querySelector('#save-api-token')
    const ADD_TOKEN_BTN = document.querySelector('#add-api-token')
    const EDITTING_TOKEN = document.querySelector('#editing-token')
    const CARD_TOKEN = document.querySelector('#card-token')
    let key_token = 1
    let token_count = 0

    EDIT_TOKEN_BTN.addEventListener('click', () => {
        this.setConfigAttribute(document.querySelectorAll('input.is-api_token_name'))
        this.setConfigAttribute(document.querySelectorAll('input.is-api_token_key'))
        this.setAttributeApiTokenBtn('none', 'initial')
        CARD_TOKEN.classList.add('border-warning')
        CARD_TOKEN.classList.remove('border-secondary')
        EDITTING_TOKEN.innerHTML = '( <i class="fas fa-edit text-dark"></i> แก้ไขรายการ... )'
    })

    CANCEL_TOKEN_BTN.addEventListener('click', () => {
        this.cancelConfigAttribute(document.querySelectorAll('input.is-api_token_name'))
        this.cancelConfigAttribute(document.querySelectorAll('input.is-api_token_key'))
        this.setAttributeApiTokenBtn('initial', 'none')
        CARD_TOKEN.classList.add('border-secondary')
        CARD_TOKEN.classList.remove('border-warning')
        EDITTING_TOKEN.innerHTML = ''
    })

    ADD_TOKEN_BTN.addEventListener('click', () => {
        let ITEM = document.querySelector('#item_list_token')

        let ROW = document.createElement('div')
        ROW.setAttribute('class', 'row px-3 pt-3 pb-0 bg-light')
        ROW.setAttribute('id', 'row_token-'+key_token)

        let COL_3 = document.createElement('div')
        COL_3.setAttribute('class', 'col-12 col-lg-3')

        let API_NAME = document.createElement('input')
        API_NAME.setAttribute('type', 'text')
        API_NAME.setAttribute('placeholder', 'ชื่อ Token Key')
        API_NAME.setAttribute('name', 'token['+key_token+'][name]')
        API_NAME.setAttribute('required', 'true')
        API_NAME.setAttribute('class', 'form-control setting-form-control')
        API_NAME.setAttribute('autocomplete', 'off')

        let COL_8 = document.createElement('div')
        COL_8.setAttribute('class', 'col-12 col-lg-8')

        let API_URL = document.createElement('input')
        API_URL.setAttribute('type', 'text')
        API_URL.setAttribute('placeholder', 'Token Key')
        API_URL.setAttribute('name', 'token['+key_token+'][value]')
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
        DELETE.setAttribute('onClick', 'deleteApiToken('+ key_token +')')
        DELETE.innerHTML = '<i class="fas fa-times m-0"></i>'

        ITEM.prepend(ROW)

        ROW.append(COL_3)
        COL_3.append(API_NAME)

        ROW.append(COL_8)
        COL_8.append(API_URL)

        ROW.append(COL_1)
        COL_1.append(DELETE)

        key_token++
        this.setTokenCount('add')
    })

    function deleteApiToken(index) {
        if (confirm('ยืนยัน?')) {
            document.querySelector("#row_token-"+index).remove(index);
            this.setTokenCount('remove')
        }
    }

    function setTokenCount(action) {
        token_count = action === 'add' ? token_count+=1 : token_count-=1
        document.querySelector('#save-btn-token').style.display = token_count >= 1 ? 'block' : 'none'
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

    function setAttributeApiTokenBtn(display1, display2) {
        ADD_TOKEN_BTN.style.display = display1
        EDIT_TOKEN_BTN.style.display = display1
        
        CANCEL_TOKEN_BTN.style.display = display2
        SAVE_TOKEN_BTN.style.display = display2
    }
</script>