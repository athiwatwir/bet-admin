<form method="POST" id="e-form" action="{{ route('setting-maintenance-game-create') }}">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="form-label-group mt-3">
                <select placeholder="กลุ่มเกม" id="game-input" name="game" class="form-control" required>
                    <option value="" selected disabled>เลือกเกม</option>
                    @foreach($games as $game)
                        @if($game->maintenance == 'Y')
                            <option value="" disabled>{{ $game->name }} (กำลังปิดปรับปรุง)</option>
                        @else
                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                        @endif
                    @endforeach
                <select>
                <label for="game-input">เกมที่ปิดปรับปรุง</label>
            </div>
        </div>
        <div class="col-md-1 pr-0">
            <div class="form-group mt-3 text-center">
                <input type="checkbox" id="game-maintent-now" name="now" value="1" class="mainten-now-check">
                <label for="game-maintent-now" class="mainten-now-label">ปิดทันที</label>
            </div>
        </div>
        <div class="col-md-3 pl-0">
            <div class="form-label-group mt-3">
                <input type="datetime-local" id="game-startdate" name="startdate" value="" class="form-control" required>
                <label for="game-startdate">ตั้งแต่วันที่</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-label-group mt-3">
                <input type="datetime-local" id="game-enddate" name="enddate" value="" class="form-control" required>
                <label for="game-enddate">ถึงวันที่</label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-label-group mt-3">
                <textarea id="game-description" name="description" class="form-control" rows="5" required></textarea>
                <label for="game-enddate">เหตุผลการปิด</label>
            </div>
        </div>
        <div class="col-md-12 mt-3 text-center">
            <button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
        </div>
    </div>
</form>


<script>
    const game_mainten_now = document.querySelector('#game-maintent-now')

    game_mainten_now.addEventListener('change', () => {
        if(game_mainten_now.checked) {
            document.querySelector('#game-startdate').disabled = true
            document.querySelector('#game-startdate').required = false
        }else{
            document.querySelector('#game-startdate').disabled = false
            document.querySelector('#game-startdate').required = true
        }
    })
</script>