@extends('layouts.core')

@section('title', 'แก้ไขการตั้งค่าปรับปรุง')

@section('content')
<div class="row gutters-sm">

    <div class="col-12 col-lg-12 col-xl-12">

        <div class="portlet">

            <div class="portlet-body pt-4">
                <div class="row">
                    <div class="col-12">
                        <form method="POST" id="e-form" action="{{ route('setting-maintenance-transaction-update') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-label-group mt-3">
                                        <select placeholder="กลุ่มเกม" id="transaction-input" name="type" class="form-control" @if($mainten->now) disabled @endif required>
                                            <option value="" disabled>เลือกรายการ</option>
                                            <option value="deposit" 
                                                @if($mainten->transaction == 'deposit') selected @endif
                                                @if($mainten->now) disabled @endif>
                                                ฝาก
                                            </option>
                                            <option value="withdraw" 
                                                @if($mainten->transaction == 'withdraw') selected @endif
                                                @if($mainten->now) disabled @endif>
                                                ถอน
                                            </option>
                                            <option value="deposit-withdraw" 
                                                @if($mainten->transaction == 'deposit-withdraw') selected @endif
                                                @if($mainten->now) disabled @endif>
                                                ฝาก-ถอน
                                            </option>
                                        <select>
                                        <label for="transaction-input">รายการที่ปิดปรับปรุง</label>
                                    </div>
                                </div>
                                <div class="col-md-1 pr-0">
                                    <div class="form-group mt-3 text-center">
                                        <input type="checkbox" id="transaction-maintent-now" name="now" value="1" @if($mainten->now) checked disabled @endif class="mainten-now-check">
                                        <label for="transaction-maintent-now" class="mainten-now-label">ปิดทันที</label>
                                    </div>
                                </div>
                                <div class="col-md-3 pl-0">
                                    <div class="form-label-group mt-3">
                                        <input type="datetime-local" id="transaction-startdate" name="startdate" value="{{ date('Y-m-d\TH:i', strtotime($mainten->startdate)) }}" class="form-control" @if($mainten->now) disabled @endif required>
                                        <label for="transaction-startdate">ตั้งแต่วันที่</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-label-group mt-3">
                                        <input type="datetime-local" id="transaction-enddate" name="enddate" value="{{ date('Y-m-d\TH:i', strtotime($mainten->enddate)) }}" class="form-control" required>
                                        <label for="transaction-enddate">ถึงวันที่</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-label-group mt-3">
                                        <textarea id="transaction-description" name="description" class="form-control" rows="5" required>{{ $mainten->description }}</textarea>
                                        <label for="transaction-enddate">เหตุผลการปิด</label>
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
    const mainten_now = document.querySelector('#transaction-maintent-now')

    mainten_now.addEventListener('change', () => {
        if(mainten_now.checked) {
            document.querySelector('#transaction-startdate').disabled = true
            document.querySelector('#transaction-startdate').required = false
        }else{
            document.querySelector('#transaction-startdate').disabled = false
            document.querySelector('#transaction-startdate').required = true
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