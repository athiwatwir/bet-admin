<!-- Admin Register Modal -->
<div class="modal fade" id="adminRegisterModal" tabindex="-1" role="dialog" aria-labelledby="adminRegisterModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-50" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/admins/register') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ลงทะเบียนผู้ดูแลระบบ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อผู้ใช้') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="Username" id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('รหัสผ่าน') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อ - สกุล') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row g-0">
                        <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('เบอร์ติดต่อ') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input placeholder="ตัวเลขเท่านั้น" id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="line" class="col-md-4 col-form-label text-md-right">{{ __('ไลน์') }}</label>

                        <div class="col-md-6">
                            <input id="line" type="text" class="form-control" name="line" value="{{ old('line') }}" autocomplete="line">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('ตำแหน่ง') }} <span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <select id="role" name="role" class="form-control" required>
                                <option value="" selected disabled>กำหนดตำแหน่ง</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>