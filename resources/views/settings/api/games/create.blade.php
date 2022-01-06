<div class="row">
    <div class="col-12">
        <form method="POST" id="e-form" action="{{ route('setting-api-game-create') }}">
            @csrf
            <div class="card">
                <div class="bg-light p-2">
                    <strong>รายละเอียดเกม</strong>
                </div>
                <div class="card-body bg-light">
                    <div class="form-label-group">
                        <input placeholder="ชื่อเกม" id="name" name="name" type="text" value="" class="form-control" required autocomplete="off">
                        <label for="name">ชื่อเกม</label>
                    </div>
                    <div class="form-label-group mt-3">
                        <input placeholder="รหัสเกม" id="code-input" name="code" type="text" value="" class="form-control" required autocomplete="off">
                        <label for="code">รหัสเกม <small>(ภาษาอังกฤษตัวใหญ่ทั้งหมด)</small></label>
                    </div>
                </div>
            </div>
            <div class="card mt-4">
                <div class="bg-light p-2">
                    <strong>รายการ API Domain</strong>
                    <button type="button" id="add-create-api-game-url" class="btn btn-vv-sm btn-primary mx-2" title="เพิ่มรายการ">+</button>
                </div>
                @include('settings.api.games.components.create_api_game_url')
            </div>
            <div class="card mt-4">
                <div class="bg-light p-2">
                    <strong>รายการ Token Key</strong>
                    <button type="button" id="add-create-api-game-token" class="btn btn-vv-sm btn-primary mx-2" title="เพิ่มรายการ">+</button>
                </div>
                @include('settings.api.games.components.create_api_game_token')
            </div>
            
            <div class="text-center p-2 mt-3">
                <button type="submit" class="btn btn-sm btn-primary px-4">บันทึก</button>
            </div>
        </form>
    </div>
</div>

<script>
    const CODE_INPUT = document.querySelector('#code-input')

    CODE_INPUT.addEventListener('keyup', () => {
        CODE_INPUT.value = CODE_INPUT.value.replace(/[^A-Za-z]/ig, '').toUpperCase()
    })

    function removeContent(type, index) {
        if (confirm('ยืนยัน?')) {
            document.querySelector("#row_"+type+"-"+index).remove(index);
        }
    }
</script>