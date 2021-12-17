<form method="POST" action="/transaction/promotion-adjust">
    @csrf
    <section>
        <div class="row mb-2">
            <div class="col-12 col-lg-8">

                <div class="bg-light p-2 rounded">

                    <div class="form-label-group mb-3">
                        <input placeholder="รายละเอียดเกี่ยวกับโปรโมชั่น" id="description" name="description" type="text" value="" class="form-control" required>
                        <label for="description">รายละเอียดเกี่ยวกับโปรโมชั่น</label>
                    </div>

                    <div class="form-label-group">
                        <input placeholder="จำนวนเงิน" id="amount" name="amount" type="number" value="" class="form-control" required>
                        <label for="amount">จำนวนเงิน</label>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <section>
        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="pt-2 mb-0">
                    <label class="form-switch form-switch form-switch-primary">
                        <input type="checkbox" id="all-user" name="all_user" value="1" class="js-form-advanced-required-toggler">
                        <i data-on="&#10004;" data-off="&#10005;"></i>
                        <span>สมาชิกทุกคน</span>
                    </label>
                </div>
            </div>

            <div class="col-12 col-lg-3">
                <div class="pt-2 mb-0">
                    <label class="form-switch form-switch form-switch-primary">
                        <input type="checkbox" id="level-user" name="level_user" value="1" data-toggle="collapse" data-target="#productConfigurator" class="js-form-advanced-required-toggler">
                        <i data-on="&#10004;" data-off="&#10005;"></i>
                        <span>กลุ่มลูกค้า</span>
                    </label>
                </div>
            </div>
        </div>

        <div id="productConfigurator" class="collapse">
            <div class="border-top mt-3 pt-3">

                <p>เลือกกลุ่มลูกค้า</p>

                <div class="form-label-group mb-3 pl-3">
                    <div class="row">
                        @foreach($user_levels as $level)
                            <div class="col-12 col-lg-2">
                                <label class="form-checkbox form-checkbox-primary form-checkbox-bordered">
                                    <input type="checkbox" class="selected-for-user-level" name="level[]" value="{{ $level->id }}">
                                    <i></i> {{ $level->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>

    <button type="submit" id="btn-confirm-disabled" class="btn btn-sm btn-primary" disabled><i class="fi fi-check"></i> ยืนยัน</button>
    <button type="submit" id="btn-confirm" class="btn btn-sm btn-primary ml-0" style="display: none;"><i class="fi fi-check"></i> ยืนยัน</button>
</form>

<script>
    let userAll = document.querySelector('#all-user')
    let userLevel = document.querySelector('#level-user')
    let btnDisabled = document.querySelector('#btn-confirm-disabled')
    let btnConfirm = document.querySelector('#btn-confirm')

    userAll.addEventListener('click', () => {
        if(userLevel.checked === true) userLevel.click()
        checkBtnDisabled()
    })

    userLevel.addEventListener('click', () => {
        if(userAll.checked === true) userAll.click()
        checkBtnDisabled()
    })

    function checkBtnDisabled() {
        if(userAll.checked === false && userLevel.checked === false) {
            btnDisabled.style.display = 'initial'
            btnConfirm.style.display = 'none'
        }
        if(userAll.checked === true || userLevel.checked === true) {
            btnDisabled.style.display = 'none'
            btnConfirm.style.display = 'initial'
        }
    }
</script>