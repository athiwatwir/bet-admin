<div class="row">
    <div class="col-12">
        <form method="POST" id="e-form" action="{{ route('setting-api-game-create') }}">
            @csrf
            <div class="form-label-group mb-4">
                <input placeholder="ชื่อเกม" id="name" name="name" type="text" value="" class="form-control" required>
                <label for="name">ชื่อเกม</label>
            </div>
            <div class="card">
                <div class="bg-light p-2">
                    <strong>รายการ URL</strong>
                    <button type="button" id="add-create-api-game-url" class="btn btn-vv-sm btn-primary mx-2" title="เพิ่มรายการ">+</button>
                </div>
                <div id="body-create-api-game-url" class="card-body bg-light">
                    <div id="row_url-0" class="row">
                        <div class="col-12 col-lg-11">
                            <div class="form-label-group mb-3">
                                <input placeholder="URL" name="url[0][name]" type="text" value="" class="form-control" required>
                                <label>URL</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-1 text-center mt-2">
                            <button type="button" id="remove-create-api-game-config" class="btn btn-vv-sm btn-danger" onClick="removeContent('url', '0')">X</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-4">
                <div class="bg-light p-2">
                    <strong>รายการพารามิเตอร์</strong>
                    <button type="button" id="add-create-api-game-config" class="btn btn-vv-sm btn-primary mx-2" title="เพิ่มรายการ">+</button>
                </div>
                <div id="body-create-api-game-config" id="e-card-body" class="card-body bg-light">
                
                    <div id="row_config-0" class="row">
                        <div class="col-12 col-lg-3">
                            <div class="form-label-group mb-3">
                                <input placeholder="ชื่อรายการ" name="config[0][key_name]" type="text" value="" class="form-control" required>
                                <label>ชื่อรายการ</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <div class="form-label-group mb-3">
                                <select id="select_options" name="config[0][method]" class="form-control bs-select">
                                    <option value="POST">POST</option>
                                    <option value="GET">GET</option>
                                </select>
                                <label for="select_options">Method</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-label-group mb-3">
                                <input placeholder="พารามิเตอร์" name="config[0][parameter]" type="text" value="" class="form-control" required>
                                <label>พารามิเตอร์</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-1 text-center mt-2">
                            <button type="button" id="remove-create-api-game-config" class="btn btn-vv-sm btn-danger" onClick="removeContent('config', '0')">X</button>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="text-center p-2 mt-3">
                <button type="submit" class="btn btn-sm btn-primary px-4">บันทึก</button>
            </div>
        </form>
    </div>
</div>

<script>
    let add_config = document.querySelector('#add-create-api-game-config')
    let add_url = document.querySelector('#add-create-api-game-url')
    let key_config = 1
    let key_url = 1

    add_url.addEventListener('click', () => {
        let form = document.querySelector('#body-create-api-game-url')
        
        let ROW = document.createElement('div')
        ROW.setAttribute('class', 'row')
        ROW.setAttribute('id', 'row_url-'+key_url)

        let COL_1_1 = document.createElement('div')
        COL_1_1.setAttribute('class', 'col-12 col-lg-11')

        let COL_1_2 = document.createElement('div')
        COL_1_2.setAttribute('class', 'form-label-group mb-3')

        let URL = document.createElement('input')
        URL.setAttribute('type', 'text')
        URL.setAttribute('placeholder', 'URL')
        URL.setAttribute('name', 'url['+key_url+'][name]')
        URL.setAttribute('required', 'true')
        URL.setAttribute('class', 'form-control')

        let LABEL_URL = document.createElement("label")
        LABEL_URL.innerText = "URL"

        let COL_2= document.createElement("div")
        COL_2.setAttribute("class", "col-12 col-lg-1 pt-3 text-center")

        let REMOVE = document.createElement("button")
        REMOVE.setAttribute("class", "btn btn-vv-sm btn-danger")
        REMOVE.setAttribute("type", "button")
        REMOVE.setAttribute("title", "ลบรายการที่เลือก")
        REMOVE.setAttribute("onClick", "removeContent('url', "+ key_url +")")
        REMOVE.innerText = 'X'

        form.prepend(ROW)
        ROW.append(COL_1_1)
        COL_1_1.append(COL_1_2)
        COL_1_2.append(URL)
        COL_1_2.append(LABEL_URL)
        
        ROW.append(COL_2)
        COL_2.append(REMOVE)

        key_url++
    })

    add_config.addEventListener('click', () => {
        let form = document.querySelector("#body-create-api-game-config");

        let ROW = document.createElement('div')
        ROW.setAttribute("class", "row")
        ROW.setAttribute("id", "row_config-"+key_config)

        let COL_1_1 = document.createElement('div')
        COL_1_1.setAttribute("class", "col-12 col-lg-3")

        let COL_1_2 = document.createElement('div')
        COL_1_2.setAttribute("class", "form-label-group mb-3")

        let KEYNAME = document.createElement("input")
        KEYNAME.setAttribute("type", "text")
        KEYNAME.setAttribute("placeholder", "ชื่อรายการ")
        KEYNAME.setAttribute("name", "config["+key_config+"][key_name]")
        KEYNAME.setAttribute("required", "true")
        KEYNAME.setAttribute("class", "form-control")

        let LABEL_KEYNAME = document.createElement("label")
        LABEL_KEYNAME.innerText = "ชื่อรายการ"

        // END COLLUMN 1

        let COL_2_1 = document.createElement("div")
        COL_2_1.setAttribute("class", "col-12 col-lg-2")

        let COL_2_2 = document.createElement('div')
        COL_2_2.setAttribute("class", "form-label-group mb-3")

        let SELECT = document.createElement("select")
        SELECT.setAttribute("class", "form-control bs-select")
        SELECT.setAttribute("id", "method")
        SELECT.setAttribute("name", "config["+key_config+"][method]")

        let OPTION_1 = document.createElement("option")
        OPTION_1.setAttribute("value", "POST")
        OPTION_1.innerText = "POST"

        let OPTION_2 = document.createElement("option")
        OPTION_2.setAttribute("value", "GET")
        OPTION_2.innerText = "GET"

        let LABEL_METHOD = document.createElement("label")
        LABEL_METHOD.setAttribute("for", "method")
        LABEL_METHOD.innerText = "Method"

        // END COLLUMN 2

        let COL_3_1 = document.createElement("div")
        COL_3_1.setAttribute("class", "col-12 col-lg-6")

        let COL_3_2 = document.createElement('div')
        COL_3_2.setAttribute("class", "form-label-group mb-3")

        let PARAMETER = document.createElement("input")
        PARAMETER.setAttribute("type", "text")
        PARAMETER.setAttribute("placeholder", "พารามิเตอร์")
        PARAMETER.setAttribute("name", "config["+key_config+"][parameter]")
        PARAMETER.setAttribute("required", "true")
        PARAMETER.setAttribute("class", "form-control")

        let LABEL_PARAMETER = document.createElement("label")
        LABEL_PARAMETER.innerText = "พารามิเตอร์"

        // END COLLUMN 3

        let COL_4 = document.createElement("div")
        COL_4.setAttribute("class", "col-12 col-lg-1 pt-3 text-center")

        let REMOVE = document.createElement("button")
        REMOVE.setAttribute("class", "btn btn-vv-sm btn-danger")
        REMOVE.setAttribute("type", "button")
        REMOVE.setAttribute("title", "ลบรายการที่เลือก")
        REMOVE.setAttribute("onClick", "removeContent('config', "+ key_config +")")
        REMOVE.innerText = 'X'

        form.prepend(ROW)
        ROW.append(COL_1_1)
        COL_1_1.append(COL_1_2)
        COL_1_2.append(KEYNAME)
        COL_1_2.append(LABEL_KEYNAME)

        ROW.append(COL_2_1)
        COL_2_1.append(COL_2_2)
        COL_2_2.append(SELECT)
        SELECT.append(OPTION_1)
        SELECT.append(OPTION_2)
        COL_2_2.append(LABEL_METHOD)

        ROW.append(COL_3_1)
        COL_3_1.append(COL_3_2)
        COL_3_2.append(PARAMETER)
        COL_3_2.append(LABEL_PARAMETER)

        ROW.append(COL_4)
        COL_4.append(REMOVE)

        key_config++

        // document.querySelector("#e-card-body")[0];
    })

    function removeContent(type, index) {
        if (confirm('ยืนยัน?')) {
            document.querySelector("#row_"+type+"-"+index).remove(index);
        }
    }
</script>