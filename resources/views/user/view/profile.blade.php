<div class="row">
    <div class="col-md-12 text-right mb-3">
        <button type="button" class="btn btn-vv-sm btn-primary" onClick="editProfile()"><small><i class="fi fi-pencil fs--14"></i> แก้ไขรายละเอียด</small></button>
    </div>

    <div class="col-md-5 mb-2">
        <div class="card">
            <div class="card-body text-center">
                <small>ชื่อผู้ใช้</small>
                <h3 class="text-dark mb-2">{{ $profile->username }}</h3>
                <p class="mb-1">สถานะ : 
                    <label class="switch-user-profile-active">
                        @if($profile->is_active == 'Y')
                            <input class="checkbox-user-profile-active js-ajax-confirm" type="checkbox" 
                                    data-href="/users/active/{{ $profile->id }}/{{ $profile->username }}"
                                    data-ajax-confirm-body="ยืนยันการแก้ไขสถานะผู้ใช้งาน {{ $profile->username }} ?" 

                                    data-ajax-confirm-btn-yes-class="btn-sm btn-primary" 
                                    data-ajax-confirm-btn-yes-text="ยืนยัน" 
                                    data-ajax-confirm-btn-yes-icon="fi fi-check" 

                                    data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                                    data-ajax-confirm-btn-no-text="ยกเลิก" 
                                    data-ajax-confirm-btn-no-icon="fi fi-close" checked>
                            <span class="slider-user-profile-active round"><small class="text-white">เปิดใช้งาน</small></span>
                        @else
                            <input class="checkbox-user-profile-active js-ajax-confirm" type="checkbox" 
                                    data-href="/users/active/{{ $profile->id }}/{{ $profile->username }}"
                                    data-ajax-confirm-body="ยืนยันการแก้ไขสถานะผู้ใช้งาน {{ $profile->username }} ?" 

                                    data-ajax-confirm-btn-yes-class="btn-sm btn-primary" 
                                    data-ajax-confirm-btn-yes-text="ยืนยัน" 
                                    data-ajax-confirm-btn-yes-icon="fi fi-check" 

                                    data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                                    data-ajax-confirm-btn-no-text="ยกเลิก" 
                                    data-ajax-confirm-btn-no-icon="fi fi-close">
                            <span class="slider-user-profile-active round"><small class="text-white">ปิดใช้งาน</small></span>
                        @endif
                    </label>
                </p>
                <p class="mb-4">วันที่สมัคร : {{ date('d-m-Y', strtotime($profile->created_at)) }}</p>
                <p class="mb-0">
                    <a	href="#!" 
                        class="js-ajax-confirm btn btn-vv-sm btn-danger" 
                        data-href="/users/delete/{{ $profile->id }}/{{ $profile->username }}"
                        data-ajax-confirm-body="ยืนยันการลบบัญชีผู้ใช้งาน {{ $profile->username }} ?" 

                        data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                        data-ajax-confirm-btn-yes-text="ลบข้อมูล" 
                        data-ajax-confirm-btn-yes-icon="fi fi-check" 

                        data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                        data-ajax-confirm-btn-no-text="ยกเลิก" 
                        data-ajax-confirm-btn-no-icon="fi fi-close">
                        <small><i class="fi fi-thrash fs--14"></i> ลบผู้ใช้</small>
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <form novalidate class="bs-validate" id="form_id" method="post" action="{{ url('users/edit/profile') }}">
                @csrf
                    <div class="form-group row">
                        <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('ชื่อ - สกุล') }} <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <input id="name" type="text" class="form-control is-input-display @error('name') is-invalid @enderror" name="name" value="{{ $profile->name }}" required disabled autocomplete="name">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row g-0">
                        <label for="phone" class="col-md-3 col-form-label text-md-right">{{ __('เบอร์ติดต่อ') }} <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <input placeholder="ตัวเลขเท่านั้น" id="phone" type="number" class="form-control is-input-display @error('phone') is-invalid @enderror" name="phone" value="{{ $profile->phone }}" required disabled autocomplete="phone">

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="line" class="col-md-3 col-form-label text-md-right">{{ __('ไลน์') }}</label>

                        <div class="col-md-9">
                            <input id="line" type="text" class="form-control is-input-display" name="line" value="{{ $profile->line }}" disabled autocomplete="line">
                        </div>
                    </div>

                    <input type="hidden" name="id" value="{{ $profile->id }}">

                    <div id="is-edit-profile-btn" class="form-group row" style="display: none;">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-vv-sm btn-primary"><small><i class="fi fi-check"></i> ยืนยัน</small></button>
                            <button type="button" class="btn btn-vv-sm btn-secondary" onClick="cancelEditProfile()"><small><i class="fi fi-close"></i> ยกเลิก</small></button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12 my-3"><hr/></div>
    <div class="col-md-12 text-right mb-3">
        <button type="button" class="btn btn-vv-sm btn-primary" onClick="editProfileBank()"><small><i class="fi fi-pencil fs--14"></i> แก้ไขธนาคาร</small></button>
    </div>
    <div class="col-md-5 mb-2">
        <div class="card">
            <div class="card-body">
                password reset
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <form novalidate class="bs-validate" id="form_id" method="post" action="{{ url('users/edit/bank') }}">
                @csrf
                    <div class="form-group row">
                        <label for="banks" class="col-md-3 col-form-label text-md-right">{{ __('ธนาคาร') }} <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <select id="banks" name="banks" class="form-control" disabled>
                                @if(isset($ubank))
                                    @foreach($banks as $bank)
                                        @if($bank->id == $ubank->bank_id)
                                            <option value="{{ $bank->id }}" selected disabled>{{ $bank->name }} @if($bank->name_en != '')- {{ $bank->name_en }} @endif</option>
                                        @else
                                            <option value="{{ $bank->id }}">{{ $bank->name }} @if($bank->name_en != '')- {{ $bank->name_en }} @endif</option>
                                        @endif
                                    @endforeach
                                @else
                                    <option value="" selected disabled>-- เลือกธนาคาร --</option>
                                    @foreach($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name }} @if($bank->name_en != '')- {{ $bank->name_en }} @endif</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group row g-0">
                        <label for="account_name" class="col-md-3 col-form-label text-md-right">{{ __('ชื่อบัญชี') }} <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            @if(isset($ubank))
                                <input placeholder="ชื่อบัญชี" id="account_name" type="text" class="form-control is-input-display @error('account_name') is-invalid @enderror" name="account_name" value="{{ $ubank->bank_account_name }}" required disabled autocomplete="account_name">
                            @else
                                <input placeholder="ชื่อบัญชี" id="account_name" type="text" class="form-control is-input-display @error('account_name') is-invalid @enderror" name="account_name" value="" required disabled autocomplete="account_name">
                            @endif

                            @error('account_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row g-0">
                        <label for="account_number" class="col-md-3 col-form-label text-md-right">{{ __('เลขบัญชี') }} <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            @if(isset($ubank))
                                <input placeholder="ตัวเลขเท่านั้น" id="account_number" type="number" class="form-control is-input-display @error('account_number') is-invalid @enderror" name="account_number" value="{{ $ubank->bank_account_number }}" required disabled autocomplete="account_number">
                            @else
                                <input placeholder="ตัวเลขเท่านั้น" id="account_number" type="number" class="form-control is-input-display @error('account_number') is-invalid @enderror" name="account_number" value="" required disabled autocomplete="account_number">
                            @endif

                            @error('account_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    @if(isset($ubank))
                        <input type="hidden" name="id" value="{{ $ubank->id }}">
                    @endif

                    <div id="is-edit-bank-btn" class="form-group row" style="display: none;">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-vv-sm btn-primary"><small><i class="fi fi-check"></i> ยืนยัน</small></button>
                            <button type="button" class="btn btn-vv-sm btn-secondary" onClick="cancelEditBank()"><small><i class="fi fi-close"></i> ยกเลิก</small></button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-link {
        padding: 15px 20px;
    }
    .nav-link.active {
        border-radius: 5px 0 0 5px;
    }
    .card {
        background-color: rgba(255,255,255,0.7);
        box-shadow: 4px 3px 8px 0px #eee;
    }
    .form-control {
        height: calc(0.5em + 1.56rem + 12px);
    }
</style>