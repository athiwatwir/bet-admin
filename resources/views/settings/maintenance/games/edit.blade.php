@extends('layouts.core')

@section('title', 'แก้ไขการตั้งค่าปรับปรุง')

@section('content')
<div class="row gutters-sm">

    <div class="col-12 col-lg-12 col-xl-12">

        <div class="portlet">

            <div class="portlet-body pt-4">
                <div class="row">
                    <div class="col-12">
                        <form method="POST" id="e-form" action="{{ route('setting-maintenance-game-update') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-label-group mt-3">
                                        <select placeholder="กลุ่มเกม" id="game-input" name="game" class="form-control" @if($mainten->now) disabled @endif required>
                                            <option value="" selected disabled>เลือกเกม</option>
                                            @foreach($games as $game)
                                                @if($game->id == $mainten->api_game_id)
                                                    <option value="{{ $game->id }}" selected>{{ $game->name }}</option>
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
                                        <input type="checkbox" id="game-maintent-now" name="now" value="1" class="mainten-now-check" @if($mainten->now) checked disabled @endif>
                                        <label for="game-maintent-now" class="mainten-now-label">ปิดทันที</label>
                                    </div>
                                </div>
                                <div class="col-md-3 pl-0">
                                    <div class="form-label-group mt-3">
                                        <input type="datetime-local" id="game-startdate" name="startdate" value="{{ date('Y-m-d\TH:i', strtotime($mainten->startdate)) }}" class="form-control" @if($mainten->now) disabled @endif required>
                                        <label for="game-startdate">ตั้งแต่วันที่</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-label-group mt-3">
                                        <input type="datetime-local" id="game-enddate" name="enddate" value="{{ date('Y-m-d\TH:i', strtotime($mainten->enddate)) }}" class="form-control" required>
                                        <label for="game-enddate">ถึงวันที่</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-label-group mt-3">
                                        <textarea id="game-description" name="description" class="form-control" rows="5" required>{{ $mainten->description }}</textarea>
                                        <label for="game-enddate">เหตุผลการปิด</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 text-center">
                                    <button type="submit" class="btn btn-sm btn-primary">แก้ไข</button>
                                    <a href="{{ route('setting-maintenance-index') }}" class="btn btn-sm btn-secondary">ย้อนกลับ</a>
                                </div>
                                <input type="hidden" name="id" value="{{ $mainten->id }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const mainten_now = document.querySelector('#game-maintent-now')

    mainten_now.addEventListener('change', () => {
        if(mainten_now.checked) {
            document.querySelector('#game-startdate').disabled = true
            document.querySelector('#game-startdate').required = false
        }else{
            document.querySelector('#game-startdate').disabled = false
            document.querySelector('#game-startdate').required = true
        }
    })
</script>
@endsection


<style>
    .set-d-flex {
        display: flex;
    }
    .mainten-now-check {
        width: 100%;
        height: 20px;
        margin-bottom: 5px;
        margin-top: 5px;
    }
    label.mainten-now-label {
        margin-bottom: 0;
        font-size: 14px;
    }
    .form-control:disabled, .form-control[readonly] {
        background: #e9ecef !important;
    }
</style>