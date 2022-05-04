<form method="POST" id="e-form" action="{{ route('setting-maintenance-website-create') }}">
    @csrf
    <div class="row">
        <div class="col-md-1 pr-0">
            <div class="form-group mt-3 text-center">
                <input type="checkbox" id="website-maintent-now" name="now" value="1" class="mainten-now-check">
                <label for="website-maintent-now" class="mainten-now-label">ปิดทันที</label>
            </div>
        </div>
        <div class="col-md-3 pl-0">
            <div class="form-label-group mt-3">
                <input type="datetime-local" id="website-startdate" name="startdate" value="" class="form-control" required>
                <label for="website-startdate">ตั้งแต่วันที่</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-label-group mt-3">
                <input type="datetime-local" id="website-enddate" name="enddate" value="" class="form-control" required>
                <label for="website-enddate">ถึงวันที่</label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-label-group mt-3">
                <textarea id="website-description" name="description" class="form-control" rows="5" required></textarea>
                <label for="website-enddate">เหตุผลการปิด</label>
            </div>
        </div>
        <div class="col-md-12 mt-3 text-center">
            <button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
        </div>
    </div>
</form>


<script>
    const web_mainten_now = document.querySelector('#website-maintent-now')

    web_mainten_now.addEventListener('change', () => {
        if(web_mainten_now.checked) {
            document.querySelector('#website-startdate').disabled = true
            document.querySelector('#website-startdate').required = false
        }else{
            document.querySelector('#website-startdate').disabled = false
            document.querySelector('#website-startdate').required = true
        }
    })
</script>