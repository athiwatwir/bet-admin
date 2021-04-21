<!-- NAVIGATION -->
<div class="collapse navbar-collapse px-5 pl-0-xs pr-0-xs" id="navbarMainNav">

@include('layouts.header.logo_mobile')

<!-- Dropdowns -->
<ul class="navbar-nav align-items-center">
    <li class="nav-item dropdown">
        <a href="#" class="nav-link nav-link-caret-hide dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainNavFeatures">
            <i class="fi fi-shield-ok float-start m-0"></i>
            <span>Users</span> 
        </a>

        <div class="dropdown-menu dropdown-menu-hover w--300 p-0 border border-light overflow-hidden" aria-labelledby="mainNavFeatures">
            <div class="row no-gutters bg-gradient-secondary">

                <!-- REMOVE BAR IF NOT NEEDED -->
                <div class="col-2 d-none d-lg-block"><!-- empty -->
                    <!-- text-rotate-90 , text-rotate-180 -->
                    <p class="h6 font-weight-medium mb-0 text-white text-rotate-180 text-center position-absolute d-middle">
                        สมาชิก • ผู้ดูแลระบบ
                    </p>
                </div>

                <div class="col bg-white overflow-hidden">
                    <ul class="mx-0 px-0 my-2">
                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/users') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-users float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">All Users</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    สมาชิกทั้งหมด
                                </span>
                            </a>
                        </li>

                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/admins') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-star-empty-radius float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">All Admins</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    ผู้ดูแลระบบ
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </li>
    

    <!-- SETTING -->
    <li class="nav-item dropdown">
        <a href="#" class="nav-link nav-link-caret-hide dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainNavFeatures">
            <i class="fi fi-cogs float-start m-0"></i>
            <span>Setting</span>
        </a>

        <div class="dropdown-menu dropdown-menu-hover w--300 p-0 border border-light overflow-hidden" aria-labelledby="mainNavFeatures">

            <div class="row no-gutters bg-gradient-secondary">


                <!-- REMOVE BAR IF NOT NEEDED -->
                <div class="col-2 d-none d-lg-block"><!-- empty -->
                    
                    <!-- text-rotate-90 , text-rotate-180 -->
                    <p class="h6 font-weight-medium mb-0 text-white text-rotate-180 text-center position-absolute d-middle">
                        BONUS • 30 DAYS • FREE
                    </p>

                </div>

                <div class="col bg-white overflow-hidden">

                    <ul class="mx-0 px-0 my-2">

                        <li class="dropdown-item text-wrap">
                            <a href="../layout_1/index.html" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-round-lightning float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">Currency</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    ตั้งค่าสกุลเงิน/อัตราแลกเปลี่ยน
                                </span>
                            </a>
                        </li>

                        <li class="dropdown-item text-wrap">
                            <a href="{{ route('cbank') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-round-lightning float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">Banking Account</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    จัดการธนาคารรับโอนเงิน
                                </span>
                            </a>
                        </li>

                        <li class="dropdown-item text-wrap">
                            <a href="../layout_2/index.html" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-graph float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">Strategic Business</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    STARTING WITH $49 / mo
                                </span>
                            </a>
                        </li>

                        <li class="dropdown-item text-wrap">
                            <a href="../layout_3/index.html" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-gps float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">Advanced Marketer</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    STARTING WITH $89 / mo
                                </span>
                            </a>
                        </li>

                    </ul>

                    <div class="position-relative bg-theme-color-light py-4 px-3">

                        <h6>Enterprise</h6>

                        <ul class="mx-0 px-0">

                            <li class="dropdown-item text-wrap bg-transparent">
                                <a href="#!" class="dropdown-link bg-transparent text-dark px-2 py-1">
                                    <i class="fi fi-arrow-end"></i>
                                    QA Testing
                                </a>
                            </li>

                            <li class="dropdown-item text-wrap bg-transparent">
                                <a href="#!" class="dropdown-link bg-transparent text-dark px-2 py-1">
                                    <i class="fi fi-arrow-end"></i>
                                    API
                                </a>
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </li>

</ul>
<!-- /Dropdowns -->

</div>
<!-- /NAVIGATION -->