@extends('layouts.core')

@section('title', 'เพิ่มตำแหน่งผู้ดูแลระบบ')

@section('content')
<div class="row gutters-sm">

    <!-- inbox list -->
    <div class="col-12 col-lg-12 col-xl-12">

        <!-- portlet -->
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">

                    <a href="{{ route('role') }}" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3">
                        < ย้อนกลับ
                    </a>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    เพิ่มตำแหน่งผู้ดูแลระบบ
                </span>
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-2 px-5">

                <form method="POST" action="{{ route('role-store') }}">
                @csrf

                    <div class="form-group row">
                        
                        <div class="col-md-12">
                            <label for="name" class="col-form-label text-md-right">{{ __('ชื่อตำแหน่ง') }} <span class="text-danger">*</span></label>
                            <input placeholder="ชื่อตำแหน่ง" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <hr class="mb-2"/>

                    <label class="col-md-12 col-form-label pb-0 pl-0"><strong>{{ __('สิทธิ์การเข้าถึง') }}</strong></label>
                    <div class="card mx-3">
                        <div class="card-body bg-light">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <p class="mb-0">
                                        <strong class="mr-3">จัดการผู้ใช้งาน</strong>
                                        <button type="button" class="btn btn-vv-sm btn-primary fs--10" id="userAllCheck">เลือกทั้งหมด</button>
                                        <button type="button" class="btn btn-vv-sm btn-secondary fs--10 ml-0" id="userAllUnCheck" style="display: none;">ยกเลิกทั้งหมด</button>
                                    </p>
                                    <div class="row px-3">
                                        <div class="col-md-2">
                                            <div class="form-group ml-1 mt-1">
                                                <input type="checkbox" id="user_check" name="user_check" class="mr-1">
                                                <label for="user_check">สมาชิก</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group ml-1 mt-1">
                                                <input type="checkbox" id="level_check" name="level_check" class="mr-1">
                                                <label for="level_check">กลุ่มลูกค้า</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group ml-1 mt-1">
                                                <input type="checkbox" id="admin_check" name="admin_check" class="mr-1">
                                                <label for="admin_check">ผู้ดูแลระบบ</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group ml-1 mt-1">
                                                <input type="checkbox" id="role_check" name="role_check" class="mr-1">
                                                <label for="role_check">ตำแหน่งผู้ดูแลระบบ</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr/>

                                <div class="col-md-12">
                                    <strong>การเงิน</strong>
                                    <div class="row px-3">
                                        <div class="col-md-12">
                                            <div class="form-group ml-1 mt-1">
                                                <input type="checkbox" id="payment_transaction_check" name="payment_transaction_check" class="mr-1">
                                                <label for="payment_transaction_check">รายการเคลื่อนไหวทางการเงินทั้งหมด [ <small>คำร้องการฝากเงิน, การถอนเงิน, รายการโอนในระบบ, Adjust</small> ]</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <hr/>
                
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-sm">บันทึก</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>

</div>

<script>
    let userAllCheck = document.querySelector('#userAllCheck')
    let userAllUnCheck = document.querySelector('#userAllUnCheck')

    userAllCheck.addEventListener('click', () => {
        userAllCheck.style.display = 'none'
        userAllUnCheck.style.display = 'initial'
        document.querySelector('#user_check').checked = true
        document.querySelector('#level_check').checked = true
        document.querySelector('#admin_check').checked = true
        document.querySelector('#role_check').checked = true
    })

    userAllUnCheck.addEventListener('click', () => {
        userAllCheck.style.display = 'initial'
        userAllUnCheck.style.display = 'none'
        document.querySelector('#user_check').checked = false
        document.querySelector('#level_check').checked = false
        document.querySelector('#admin_check').checked = false
        document.querySelector('#role_check').checked = false
    })
</script>
@endsection