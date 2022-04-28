<div class="row">
    <div class="col-12">
        <form method="POST" id="e-form" action="{{ route('setting-api-game-create') }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="bg-light p-2">
                    <strong>รายละเอียดเกม</strong>
                </div>
                <div class="card-body bg-light">
                    <div class="row">
                        <div class="col-12 col-lg-4 text-center align-self-center">
                            <img src="#" id="simple-img-logo" class="w-50" style="display: none;"><br/>
                            <i id="is-no-logo" class="far fa-file-image fs--40"></i><br/>
                            <input type="file" id="logo-upload" name="logo" class="fs--12 border mt-3"><br/>
                            <small id="nottice-game-logo" class="text-danger"><small>ขนาด 120 x 60 px ไฟล์ PNG ไม่เกิน 100 Kb</small></small>
                        </div>
                        <div class="col-12 col-lg-8">
                            
                            <div class="form-label-group mt-3">
                                <input placeholder="ชื่อเกม" id="name" name="name" type="text" value="" class="form-control" required autocomplete="off">
                                <label for="name">ชื่อเกม</label>
                            </div>

                            <div class="form-label-group mt-3">
                                <input placeholder="รหัสเกม" id="code-input" name="code" type="text" value="" class="form-control" required autocomplete="off">
                                <label for="code-input">รหัสเกม <small>(ภาษาอังกฤษตัวใหญ่ทั้งหมด)</small></label>
                            </div>

                            <!-- <div class="form-label-group mt-3">
                                <input placeholder="ลิงค์เกม" id="url-input" name="link" type="text" value="" class="form-control" required autocomplete="off">
                                <label for="url-input">ลิงค์เกม</label>
                            </div> -->

                            <div class="form-label-group mt-3">
                                <select placeholder="กลุ่มเกม" id="group-input" name="group" class="form-control" required>
                                    <option value="" selected disabled>เลือกกลุ่มเกม</option>
                                    @foreach($gamegroups as $gamegroup)
                                        <option value="{{ $gamegroup->id }}">{{ $gamegroup->name }}</option>
                                    @endforeach
                                <select>
                                <label for="group-input">กลุ่มเกม</label>
                            </div>

                            <div class="form-label-group mt-3">
                                <textarea placeholder="รายละเอียด" id="desc-input" name="description" type="text" value="" class="form-control" required autocomplete="off"></textarea>
                                <label for="code-input">รายละเอียดเกี่ยวกับเกม</label>
                            </div>

                        </div>
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
    const LOGO_INPUT = document.querySelector('#logo-upload')

    CODE_INPUT.addEventListener('keyup', () => {
        CODE_INPUT.value = CODE_INPUT.value.replace(/[^A-Za-z]/ig, '').toUpperCase()
    })

    LOGO_INPUT.addEventListener('change', () => {
        const [file] = LOGO_INPUT.files
        if (file) {
            document.querySelector('#simple-img-logo').style.display = 'initial'
            document.querySelector('#is-no-logo').style.display = 'none'
            document.querySelector('#simple-img-logo').src = URL.createObjectURL(file)
        }
    })

    function removeContent(type, index) {
        if (confirm('ยืนยัน?')) {
            document.querySelector("#row_"+type+"-"+index).remove(index);
        }
    }
</script>