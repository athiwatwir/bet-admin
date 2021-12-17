@extends('layouts.core')

@section('title', 'ตั้งค่า API : กลุ่มลูกค้า')

@section('content')
<div class="row gutters-sm">

<!-- navigation -->

<!-- /navigation -->


<!-- inbox list -->
    <div class="col-12 col-lg-12 col-xl-12">

        <!-- portlet -->
        <div class="portlet">

            <!-- portlet : body -->
            <div class="portlet-body pt-4">
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <section>
                            <strong class="text-dark">กลุ่มลูกค้า</strong>
                            <ul id="nav_responsive" class="nav flex-column d-none d-lg-block pl-3 mt-2">
                                @foreach($user_levels as $level)
                                    <li class="nav-item active mb-1">
                                        <i class="fi fi-arrow-end m-0 fs--11"></i> {{ $level->name }}
                                    </li>
                                @endforeach
                            </ul>
                        </section>
                    </div>
                    <div class="col-12 col-lg-9">
                        
                        <section>
                            <div class="row">
                                <div class="col-12">
                                    <h5>API เกม</h5>
                                    <div class="row">
                                        <div class="col-12 col-lg-3">
                                            <div class="pt-2 mb-0">
                                                <label class="form-switch form-switch form-switch-primary">
                                                    <input type="checkbox" id="lorem_1" name="lorem_1" value="1" class="js-form-advanced-required-toggler" checked>
                                                    <i data-on="&#10004;" data-off="&#10005;"></i>
                                                    <small>Lorem 1</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <div class="pt-2 mb-0">
                                                <label class="form-switch form-switch form-switch-primary">
                                                    <input type="checkbox" id="lorem_2" name="lorem_2" value="1" class="js-form-advanced-required-toggler" checked>
                                                    <i data-on="&#10004;" data-off="&#10005;"></i>
                                                    <small>Lorem 2</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <div class="pt-2 mb-0">
                                                <label class="form-switch form-switch form-switch-primary">
                                                    <input type="checkbox" id="lorem_3" name="lorem_3" value="1" class="js-form-advanced-required-toggler" checked>
                                                    <i data-on="&#10004;" data-off="&#10005;"></i>
                                                    <small>Lorem 3</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section>
                            <div class="row">
                                <div class="col-12">
                                    <h5>API อื่นๆ</h5>
                                    <div class="row">
                                        <div class="col-12 col-lg-3">
                                            <div class="pt-2 mb-0">
                                                <label class="form-switch form-switch form-switch-primary">
                                                    <input type="checkbox" id="lorem_4" name="lorem_4" value="1" class="js-form-advanced-required-toggler" checked>
                                                    <i data-on="&#10004;" data-off="&#10005;"></i>
                                                    <small>Lorem 4</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <div class="pt-2 mb-0">
                                                <label class="form-switch form-switch form-switch-primary">
                                                    <input type="checkbox" id="lorem_5" name="lorem_5" value="1" class="js-form-advanced-required-toggler" checked>
                                                    <i data-on="&#10004;" data-off="&#10005;"></i>
                                                    <small>Lorem 5</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <div class="pt-2 mb-0">
                                                <label class="form-switch form-switch form-switch-primary">
                                                    <input type="checkbox" id="lorem_6" name="lorem_6" value="1" class="js-form-advanced-required-toggler" checked>
                                                    <i data-on="&#10004;" data-off="&#10005;"></i>
                                                    <small>Lorem 6</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <div class="pt-2 mb-0">
                                                <label class="form-switch form-switch form-switch-primary">
                                                    <input type="checkbox" id="lorem_7" name="lorem_7" value="1" class="js-form-advanced-required-toggler" checked>
                                                    <i data-on="&#10004;" data-off="&#10005;"></i>
                                                    <small>Lorem 7</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        
                        <button type="submit" id="btn-confirm" class="btn btn-sm btn-primary ml-0 py-1"><i class="fi fi-check"></i> ยืนยัน</button>
                    </div>
                </div>
            </div>
        
        </div>

    </div>

</div>
@endsection