<!-- NAVIGATION -->
<div class="collapse navbar-collapse px-5 pl-0-xs pr-0-xs" id="navbarMainNav">

@include('layouts.header.logo_mobile')

<!-- Dropdowns -->
<ul class="navbar-nav align-items-center">
    <li class="nav-item dropdown">
        <a href="#" class="nav-link nav-link-caret-hide dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainNavFeatures">
            <i class="fi fi-shield-ok float-start m-0"></i>
            <span>ผู้ใช้งาน</span> 
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
                                <span class="h5-xs d-block fs--18">สมาชิก</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    สมาชิกทั้งหมด
                                </span>
                            </a>
                        </li>

                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/admins') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-star-empty-radius float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">ผู้ดูแลระบบ</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    ผู้ดูแลระบบทั้งหมด
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </li>


    <!-- Transaction -->
    <li class="nav-item dropdown">
        <a href="#" class="nav-link nav-link-caret-hide dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainNavFeatures">
            <i class="fi fi-shield-ok float-start m-0"></i>
            <span>รายการเคลื่อนไหว</span> 
        </a>

        <div class="dropdown-menu dropdown-menu-hover w--300 p-0 border border-light overflow-hidden" aria-labelledby="mainNavFeatures">
            <div class="row no-gutters bg-gradient-secondary">

                <!-- REMOVE BAR IF NOT NEEDED -->
                <div class="col-2 d-none d-lg-block"><!-- empty -->
                    <!-- text-rotate-90 , text-rotate-180 -->
                    <p class="h6 font-weight-medium mb-0 text-white text-rotate-180 text-center position-absolute d-middle">
                        xxxx
                    </p>
                </div>

                <div class="col bg-white overflow-hidden">
                    <ul class="mx-0 px-0 my-2">
                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/transaction/payment') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-users float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">การชำระเงิน</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    รายการการเคลื่อนไหวทางการเงิน
                                </span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </li>


    <!-- Games -->
    <li class="nav-item dropdown">
        <a href="#" class="nav-link nav-link-caret-hide dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainNavFeatures">
            <i class="fi fi-shield-ok float-start m-0"></i>
            <span>เกม</span> 
        </a>

        <div class="dropdown-menu dropdown-menu-hover w--300 p-0 border border-light overflow-hidden" aria-labelledby="mainNavFeatures">
            <div class="row no-gutters bg-gradient-secondary">

                <!-- REMOVE BAR IF NOT NEEDED -->
                <div class="col-2 d-none d-lg-block"><!-- empty -->
                    <!-- text-rotate-90 , text-rotate-180 -->
                    <p class="h6 font-weight-medium mb-0 text-white text-rotate-180 text-center position-absolute d-middle">
                        รายการเกม
                    </p>
                </div>

                <div class="col bg-white overflow-hidden">
                    <ul class="mx-0 px-0 my-2">
                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/games/groups') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-users float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">กลุ่มเกม</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    กลุ่มเกมทั้งหมด
                                </span>
                            </a>
                        </li>

                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/games') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-users float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">รายการเกม</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    รายการเกมทั้งหมด
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
            <span>ตั้งค่า</span>
        </a>

        <div class="dropdown-menu dropdown-menu-hover w--300 p-0 border border-light overflow-hidden" aria-labelledby="mainNavFeatures">

            <div class="row no-gutters bg-gradient-secondary">


                <!-- REMOVE BAR IF NOT NEEDED -->
                <div class="col-2 d-none d-lg-block"><!-- empty -->
                    
                    <!-- text-rotate-90 , text-rotate-180 -->
                    <p class="h6 font-weight-medium mb-0 text-white text-rotate-180 text-center position-absolute d-middle">
                        การตั้งค่า
                    </p>

                </div>

                <div class="col bg-white overflow-hidden">

                    <ul class="mx-0 px-0 my-2">

                        <li class="dropdown-item text-wrap">
                            <a href="#!" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-round-lightning float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">สกุลเงิน</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    ตั้งค่าสกุลเงิน/อัตราแลกเปลี่ยน
                                </span>
                            </a>
                        </li>

                        <li class="dropdown-item text-wrap">
                            <a href="{{ route('cbank') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-round-lightning float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">บัญชีธนาคาร</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    จัดการธนาคารรับโอนเงิน
                                </span>
                            </a>
                        </li>

                        <li class="dropdown-item text-wrap">
                            <a href="{{ route('banks') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-graph float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">รายชื่อธนาคาร</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    รายชื่อธนาคารทั้งหมด
                                </span>
                            </a>
                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </li>

</ul>
<!-- /Dropdowns -->

</div>
<!-- /NAVIGATION -->