<form method="POST" id="e-form" action="{{ route('setting-maintenance-transaction-create') }}">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="form-label-group mt-3">
                <select placeholder="กลุ่มเกม" id="transaction-input" name="type" class="form-control" required>
                    <option value="" selected disabled>เลือกรายการ</option>
                    <option value="deposit">ฝาก</option>
                    <option value="withdraw">ถอน</option>
                    <option value="deposit-withdraw">ฝาก-ถอน</option>
                <select>
                <label for="transaction-input">รายการที่ปิดปรับปรุง</label>
            </div>
        </div>
        <div class="col-md-1 pr-0">
            <div class="form-group mt-3 text-center">
                <input type="checkbox" id="transaction-maintent-now" name="now" value="1" class="mainten-now-check">
                <label for="transaction-maintent-now" class="mainten-now-label">ปิดทันที</label>
            </div>
        </div>
        <div class="col-md-3 pl-0">
            <div class="form-label-group mt-3">
                <input type="datetime-local" id="transaction-startdate" name="startdate" value="" class="form-control" required>
                <label for="transaction-startdate">ตั้งแต่วันที่</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-label-group mt-3">
                <input type="datetime-local" id="transaction-enddate" name="enddate" value="" class="form-control" required>
                <label for="transaction-enddate">ถึงวันที่</label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-label-group mt-3">
                <textarea id="transaction-description" name="description" class="form-control" rows="5" required></textarea>
                <label for="transaction-enddate">เหตุผลการปิด</label>
            </div>
        </div>
        <div class="col-md-12 mt-3 text-center">
            <button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
        </div>
    </div>
</form>


<script>
    const trans_mainten_now = document.querySelector('#transaction-maintent-now')

    trans_mainten_now.addEventListener('change', () => {
        if(trans_mainten_now.checked) {
            document.querySelector('#transaction-startdate').disabled = true
            document.querySelector('#transaction-startdate').required = false
        }else{
            document.querySelector('#transaction-startdate').disabled = false
            document.querySelector('#transaction-startdate').required = true
        }
    })
</script>