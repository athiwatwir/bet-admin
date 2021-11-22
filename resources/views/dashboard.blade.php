@extends('layouts.core')

@section('title', 'Dashboard')

@section('content')
<div class="row gutters-sm pb-4 border-bottom">
    <div class="col-12 col-md-6 col-xl-3 mb-3">
        <div class="bg-white shadow-md text-dark p-3 rounded text-center">
            <span class="badge badge-light fs--45 w--100 h--100 badge-pill rounded-circle">
                <i class="fi fi-users mt-1 text-indigo"></i>
            </span>
            <h4 class="mt-3">ลูกค้าทั้งหมด</h4>
            <h1 class="mt-2 text-indigo">{{ number_format($cardInfo['userTotalAmt'],0) }}</h1>
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-3 mb-3">
        <div class="bg-white shadow-md text-dark p-3 rounded text-center">

            <span class="badge badge-light fs--45 w--100 h--100 badge-pill rounded-circle">
                <i class="fi fi-user-plus mt-1 text-success"></i>
            </span>
            <h4 class="mt-3">ลูกค้าใหม่เดือนนี้</h4>
            <h1 class="mt-2 text-success">{{ number_format($cardInfo['newUserTotalAmt'],0) }}</h1>

        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-3 mb-3">
        <div class="bg-white shadow-md text-dark p-3 rounded text-center">

            <span class="badge badge-light fs--45 w--100 h--100 badge-pill rounded-circle">
                <i class="fas fa-hand-holding-medical mt-3 text-success"></i>
            </span>

            <h4 class="mt-3">ฝากเงินเดือนนี้</h4>
            <h1 class="mt-2 text-success">฿{{ number_format($cardInfo['depositAmt'],0) }}</h1>

        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3 mb-3">
        <div class="bg-white shadow-md text-dark p-3 rounded text-center">

            <span class="badge badge-light fs--45 w--100 h--100 badge-pill rounded-circle">
                <i class="fas fa-hand-holding-usd mt-3 text-danger"></i>
            </span>

            <h4 class="mt-3">ถอนเงินเดือนนี้</h4>
            <h1 class="mt-2 text-danger">฿{{ number_format($cardInfo['withdrawAmt'],0) }}</h1>

        </div>
    </div>

</div>

<div class="row mt-5">
    <div class="col-md-12 mb-3">
        <h4>รายการ เติม-ถอน ในระบบ</h4>
    </div>
    <div class="col-md-12">
        <form method="GET" action="{{ route('dashboard') }}">
            <div class="row gutters-sm">
                <div class="col-12 col-md-2 form-group">
                    <strong>จากวันที่</strong>
                    <div class="input-group-over position-realtive z-index-1 bg-white">
                        <input type="text" name="startdate" class="form-control bg-transparent datepicker" 
                            data-today-highlight="true" 
                            data-layout-rounded="true" 
                            data-title="" 
                            data-show-weeks="true" 
                            data-today-highlight="true" 
                            data-today-btn="true" 
                            data-autoclose="true" 
                            data-format="MM/DD/YYYY"
                            data-quick-locale='{
                                "days": ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"],
                                "daysShort": ["อ.", "จ.", "อา.", "พ.", "พฤ.", "ศ.", "ส."],
                                "daysMin": ["อ.", "จ.", "อา.", "พ.", "พฤ.", "ศ.", "ส."],
                                "months": ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
                                "monthsShort": ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."],
                                "today": "วันนี้",
                                "clear": "ล้างค่า",
                                "titleFormat": "MM yyyy"}'
                            required
                            autocomplete="off">

                        <span class="fi fi-calendar fs--20 ml-4 mr-4 z-index-n1 text-muted"></span>
                    </div>					

                </div>

                <div class="col-12 col-md-2 form-group">
                    <strong>ถึงวันที่</strong>
                    <div class="input-group-over position-realtive z-index-1 bg-white">
                        <input type="text" name="enddate" class="form-control bg-transparent datepicker" 
                            data-today-highlight="true" 
                            data-layout-rounded="true" 
                            data-title="" 
                            data-show-weeks="true" 
                            data-today-highlight="true" 
                            data-today-btn="true" 
                            data-autoclose="true" 
                            data-format="MM/DD/YYYY"
                            data-quick-locale='{
                                "days": ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"],
                                "daysShort": ["อ.", "จ.", "อา.", "พ.", "พฤ.", "ศ.", "ส."],
                                "daysMin": ["อ.", "จ.", "อา.", "พ.", "พฤ.", "ศ.", "ส."],
                                "months": ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
                                "monthsShort": ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."],
                                "today": "วันนี้",
                                "clear": "ล้างค่า",
                                "titleFormat": "MM yyyy"}'
                            required
                            autocomplete="off">

                        <span class="fi fi-calendar fs--20 ml-4 mr-4 z-index-n1 text-muted"></span>
                    </div>
                </div>
                <div class="col-12 col-md-1 form-group">
                    <label></label>
                    <button class="btn btn-primary btn-block" type="submit">GO!</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-12 mt-1 px-5 py-4 border rounded bg-white shadow-md">
        @if($search_date != '')
            <p>รายการค้นหาระหว่างวันที่ {{ $search_date['start'] }} ถึง {{ $search_date['end'] }}</p>
        @endif
        @include('dashboard.payment_transactions')
    </div>
</div>
@endsection