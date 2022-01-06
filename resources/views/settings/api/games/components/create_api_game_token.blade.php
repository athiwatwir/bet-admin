<div id="body-create-api-game-token" class="card-body bg-light">
    <div id="row_token-0" class="row">
        <div class="col-12 col-lg-3">
            <div class="form-label-group mb-3">
                <input placeholder="ชื่อ Token Key" name="token[0][name]" type="text" value="" class="form-control" required autocomplete="off">
                <label>ชื่อ Token Key</label>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <div class="form-label-group mb-3">
                <input placeholder="Token Key" name="token[0][key]" type="text" value="" class="form-control" required autocomplete="off">
                <label>Token Key</label>
            </div>
        </div>
        <div class="col-12 col-lg-1 text-center mt-2">
            <button type="button" id="remove-create-api-game-config" class="btn btn-vv-sm btn-danger" onClick="removeContent('token', '0')">X</button>
        </div>
    </div>
</div>

<script>
    let add_token = document.querySelector('#add-create-api-game-token')
    let key_token = 1

    add_token.addEventListener('click', () => {
        let form = document.querySelector('#body-create-api-game-token')
        
        let ROW = document.createElement('div')
        ROW.setAttribute('class', 'row')
        ROW.setAttribute('id', 'row_token-'+key_token)

        let COL_0_1 = document.createElement('div')
        COL_0_1.setAttribute('class', 'col-12 col-lg-3')

        let COL_0_2 = document.createElement('div')
        COL_0_2.setAttribute('class', 'form-label-group mb-3')

        let NAME = document.createElement('input')
        NAME.setAttribute('type', 'text')
        NAME.setAttribute('placeholder', 'ชื่อ Token Key')
        NAME.setAttribute('name', 'token['+key_token+'][name]')
        NAME.setAttribute('required', 'true')
        NAME.setAttribute('class', 'form-control')
        NAME.setAttribute('autocomplete', 'off')

        let LABEL_NAME = document.createElement("label")
        LABEL_NAME.innerText = "ชื่อ Token Key"

        let COL_1_1 = document.createElement('div')
        COL_1_1.setAttribute('class', 'col-12 col-lg-8')

        let COL_1_2 = document.createElement('div')
        COL_1_2.setAttribute('class', 'form-label-group mb-3')

        let URL = document.createElement('input')
        URL.setAttribute('type', 'text')
        URL.setAttribute('placeholder', 'Token Key')
        URL.setAttribute('name', 'token['+key_token+'][key]')
        URL.setAttribute('required', 'true')
        URL.setAttribute('class', 'form-control')
        URL.setAttribute('autocomplete', 'off')

        let LABEL_URL = document.createElement("label")
        LABEL_URL.innerText = "Token Key"

        let COL_2= document.createElement("div")
        COL_2.setAttribute("class", "col-12 col-lg-1 pt-3 text-center")

        let REMOVE = document.createElement("button")
        REMOVE.setAttribute("class", "btn btn-vv-sm btn-danger")
        REMOVE.setAttribute("type", "button")
        REMOVE.setAttribute("title", "ลบรายการที่เลือก")
        REMOVE.setAttribute("onClick", "removeContent('token', "+ key_token +")")
        REMOVE.innerText = 'X'

        form.prepend(ROW)
        ROW.append(COL_0_1)
        COL_0_1.append(COL_0_2)
        COL_0_2.append(NAME)
        COL_0_2.append(LABEL_NAME)

        ROW.append(COL_1_1)
        COL_1_1.append(COL_1_2)
        COL_1_2.append(URL)
        COL_1_2.append(LABEL_URL)
        
        ROW.append(COL_2)
        COL_2.append(REMOVE)

        key_token++
    })
</script>