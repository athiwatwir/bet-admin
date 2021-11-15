<!-- NAVIGATION -->
<div class="collapse navbar-collapse px-5 pl-0-xs pr-0-xs" id="navbarMainNav">

@include('layouts.header.logo_mobile')
<!-- Dropdowns -->
<ul class="navbar-nav align-items-center">
    <li class="nav-item dropdown">
        <a href="#" class="nav-link nav-link-caret-hide dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainNavFeatures">
            <i class="fas fa-users-cog float-start m-0 mt-1"></i>
            <span>จัดการผู้ใช้งาน</span> 
        </a>
        <div class="dropdown-menu dropdown-menu-hover w--300 p-0 border border-light overflow-hidden" aria-labelledby="mainNavFeatures">
            <div class="row no-gutters bg-gradient-secondary">

                <!-- REMOVE BAR IF NOT NEEDED -->
                <div class="col-2 d-none d-lg-block"><!-- empty -->
                    <!-- text-rotate-90 , text-rotate-180 -->
                    <p class="h6 font-weight-medium mb-0 text-white text-rotate-180 text-center position-absolute d-middle">
                        จัดการผู้ใช้งาน
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

                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/user-levels') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-users float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">เลเวล</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    เลเวลสมาชิก
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
            <i class="fas fa-comments-dollar float-start m-0 mt-1"></i>
            <span>การเงิน</span>
        </a>

        <div class="dropdown-menu dropdown-menu-hover w--300 p-0 border border-light overflow-hidden" aria-labelledby="mainNavFeatures">
            <div class="row no-gutters bg-gradient-secondary">

                <!-- REMOVE BAR IF NOT NEEDED -->
                <div class="col-2 d-none d-lg-block"><!-- empty -->
                    <!-- text-rotate-90 , text-rotate-180 -->
                    <p class="h6 font-weight-medium mb-0 text-white text-rotate-180 text-center position-absolute d-middle">
                        การเงิน
                    </p>
                </div>

                <div class="col bg-white overflow-hidden">
                    <ul class="mx-0 px-0 my-2">
                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/transaction/payment') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fas fa-search-dollar float-start fs--25 mt--n2"></i>
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
    <!-- Football -->
    

    <!-- SETTING -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainNavHome">
            ตั้งค่า
        </a>
        <ul class="dropdown-menu dropdown-menu-clean dropdown-menu-hover" aria-labelledby="mainNavHome">
            <li class="dropdown-item dropdown">
                <a class="dropdown-link" href="#!" data-toggle="dropdown">
                    <i class="fas fa-university"></i> ธนาคาร
                </a>
                <ul class="dropdown-menu dropdown-menu-hover b-0 m-0 shadow-primary-xs">
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="{{ route('cbank') }}" >
                            บัญชีธนาคาร
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="{{ route('cbank') }}" >
                            กลุ่มบัญชีธนาคาร
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="{{ route('banks') }}" >
                            รายชื่อธนาคาร
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        
    </li>
    <li class="nav-item">
        <a href="{{ route('reports') }}" class="nav-link nav-link-caret-hide" id="">
            <i class="fas fa-chart-pie float-start m-0 mt-1"></i>
            <span>รายงาน</span>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link nav-link-caret-hide dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainNavFeatures">
            <i class="fi fi-shield-ok float-start m-0"></i>
            <span>ฟุตบอล</span> 
        </a>

        <div class="dropdown-menu dropdown-menu-hover w--300 p-0 border border-light overflow-hidden" aria-labelledby="mainNavFeatures">
            <div class="row no-gutters bg-gradient-secondary">

                <!-- REMOVE BAR IF NOT NEEDED -->
                <div class="col-2 d-none d-lg-block"><!-- empty -->
                    <!-- text-rotate-90 , text-rotate-180 -->
                    <p class="h6 font-weight-medium mb-0 text-white text-rotate-180 text-center position-absolute d-middle">
                        รายการฟุตบอล
                    </p>
                </div>

                <div class="col bg-white overflow-hidden">
                    <ul class="mx-0 px-0 my-2">
                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/football/matchs') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-users float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">แมทซ์การแข่งขัน</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    จัดการแมทซ์การแข่งขันฟุตบอล
                                </span>
                            </a>
                        </li>

                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/football/teams') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-users float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">ทีมฟุตบอล</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    ทีมฟุตบอลทั้งหมด
                                </span>
                            </a>
                        </li>

                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/football/leagues') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-users float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">รายการลีก</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    ลีกฟุตบอลทั้งหมด
                                </span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </li>

</ul>
</div>