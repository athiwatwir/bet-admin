<div class="row">
    <div class="col-md-12 text-right mb-3">
        <button type="button" class="btn btn-vv-sm btn-primary" onClick="editProfileAdmin()"><small><i class="fi fi-pencil fs--14"></i> แก้ไขรายละเอียด</small></button>
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
                                    data-href="/admins/active/{{ $profile->id }}/{{ $profile->username }}"
                                    data-ajax-confirm-body="ยืนยันการแก้ไขสถานะผู้ดูแลระบบ {{ $profile->username }} ?" 

                                    data-ajax-confirm-btn-yes-class="btn-sm btn-primary" 
                                    data-ajax-confirm-btn-yes-text="ยืนยัน" 
                                    data-ajax-confirm-btn-yes-icon="fi fi-check" 

                                    data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                                    data-ajax-confirm-btn-no-text="ยกเลิก" 
                                    data-ajax-confirm-btn-no-icon="fi fi-close" checked>
                            <span class="slider-user-profile-active round"><small class="text-white">เปิดใช้งาน</small></span>
                        @else
                            <input class="checkbox-user-profile-active js-ajax-confirm" type="checkbox" 
                                    data-href="/admins/active/{{ $profile->id }}/{{ $profile->username }}"
                                    data-ajax-confirm-body="ยืนยันการแก้ไขสถานะผู้ดูแลระบบ {{ $profile->username }} ?" 

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
                <p class="mb-4">ตำแหน่ง : XXXXXX</p>
                <p class="mb-0">
                    <a	href="#!" 
                        class="js-ajax-confirm btn btn-vv-sm btn-danger" 
                        data-href="/admins/delete/{{ $profile->id }}/{{ $profile->username }}"
                        data-ajax-confirm-body="ยืนยันการลบบัญชีผู้ดูแลระบบ {{ $profile->username }} ?" 

                        data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                        data-ajax-confirm-btn-yes-text="ลบข้อมูล" 
                        data-ajax-confirm-btn-yes-icon="fi fi-check" 

                        data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                        data-ajax-confirm-btn-no-text="ยกเลิก" 
                        data-ajax-confirm-btn-no-icon="fi fi-close">
                        <small><i class="fi fi-thrash fs--14"></i> ลบผู้ดูแลระบบ</small>
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <form novalidate class="bs-validate" id="form_id" method="post" action="{{ url('admins/edit/profile') }}">
                @csrf
                    <div class="form-group row">
                        <label for="name_admin" class="col-md-3 col-form-label text-md-right">{{ __('ชื่อ - สกุล') }} <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <input id="name_admin" type="text" class="form-control is-input-display @error('name_admin') is-invalid @enderror" name="edit_name" value="{{ $profile->name }}" required disabled autocomplete="name_admin">

                            @error('name_admin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row g-0">
                        <label for="phone_admin" class="col-md-3 col-form-label text-md-right">{{ __('เบอร์ติดต่อ') }} <span class="text-danger">*</span></label>

                        <div class="col-md-9">
                            <input placeholder="ตัวเลขเท่านั้น" id="phone_admin" type="number" class="form-control is-input-display @error('phone_admin') is-invalid @enderror" name="edit_phone" value="{{ $profile->phone }}" required disabled autocomplete="phone_admin">

                            @error('phone_admin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="line_admin" class="col-md-3 col-form-label text-md-right">{{ __('ไลน์') }}</label>

                        <div class="col-md-9">
                            <input id="line_admin" type="text" class="form-control is-input-display" name="edit_line" value="{{ $profile->line }}" disabled autocomplete="line_admin">
                        </div>
                    </div>

                    <input type="hidden" name="edit_id" value="{{ $profile->id }}">

                    <div id="is-edit-admin-profile-btn" class="form-group row" style="display: none;">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-vv-sm btn-primary"><small><i class="fi fi-check"></i> ยืนยัน</small></button>
                            <button type="button" class="btn btn-vv-sm btn-secondary" onClick="cancelEditAdminProfile()"><small><i class="fi fi-close"></i> ยกเลิก</small></button>
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