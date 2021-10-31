@extends('layouts.core')

@section('title', 'Dashboard')

@section('content')
<div class="row gutters-sm">
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

            <h4 class="mt-3">ฝากเงืนเดือนนี้</h4>
            <h1 class="mt-2 text-success">฿{{ number_format($cardInfo['depositAmt'],0) }}</h1>

        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3 mb-3">
        <div class="bg-white shadow-md text-dark p-3 rounded text-center">

            <span class="badge badge-light fs--45 w--100 h--100 badge-pill rounded-circle">
                <i class="fas fa-hand-holding-usd mt-3 text-danger"></i>
            </span>

            <h4 class="mt-3">ถอนเงืนเดือนนี้</h4>
            <h1 class="mt-2 text-danger">฿{{ number_format($cardInfo['withdrawAmt'],0) }}</h1>

        </div>
    </div>

</div>
@endsection