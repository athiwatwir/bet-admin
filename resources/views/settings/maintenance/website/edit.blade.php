@extends('layouts.core')

@section('title', 'แก้ไขการตั้งค่าปรับปรุง')

@section('content')
<div class="row gutters-sm">

    <div class="col-12 col-lg-12 col-xl-12">

        <div class="portlet">

            <div class="portlet-body pt-4">
                <div class="row">
                    <div class="col-12">
                        <form method="POST" id="e-form" action="{{ route('setting-maintenance-website-update') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-1 pr-0">
                                    <div class="form-group mt-3 text-center">
                                        <input type="checkbox" id="website-maintent-now" name="now" value="1" class="mainten-now-check" @if($mainten->now) checked disabled @endif>
                                        <label for="website-maintent-now" class="mainten-now-label">ปิดทันที</label>
                                    </div>
                                </div>
                                <div class="col-md-3 pl-0">
                                    <div class="form-label-group mt-3">
                                        <input type="datetime-local" id="website-startdate" name="startdate" value="{{ date('Y-m-d\TH:i', strtotime($mainten->startdate)) }}" class="form-control" @if($mainten->now) disabled @endif required>
                                        <label for="website-startdate">ตั้งแต่วันที่</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-label-group mt-3">
                                        <input type="datetime-local" id="website-enddate" name="enddate" value="{{ date('Y-m-d\TH:i', strtotime($mainten->enddate)) }}" class="form-control" required>
                                        <label for="website-enddate">ถึงวันที่</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-label-group mt-3">
                                        <textarea id="website-description" name="description" class="form-control" rows="5" required>{{ $mainten->description }}</textarea>
                                        <label for="website-enddate">เหตุผลการปิด</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 text-center">
                                    <button type="submit" class="btn btn-sm btn-primary">บันทึก</button>
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
    const mainten_now = document.querySelector('#website-maintent-now')

    mainten_now.addEventListener('change', () => {
        if(mainten_now.checked) {
            document.querySelector('#website-startdate').disabled = true
            document.querySelector('#website-startdate').required = false
        }else{
            document.querySelector('#website-startdate').disabled = false
            document.querySelector('#website-startdate').required = true
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