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
                        @if(session('_p')['user'])
                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/users') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-users float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">สมาชิก</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    สมาชิกทั้งหมด
                                </span>
                            </a>
                        </li>
                        @endif

                        @if(session('_p')['admin'])
                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/admins') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-star-empty-radius float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">ผู้ดูแลระบบ</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    ผู้ดูแลระบบทั้งหมด
                                </span>
                            </a>
                        </li>
                        @endif

                        @if(session('_p')['level'])
                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/user-levels') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-users float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">กลุ่มลูกค้า</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    กลุ่มลูกค้า
                                </span>
                            </a>
                        </li>
                        @endif

                        @if(session('_p')['role'])
                        <li class="dropdown-item text-wrap">
                            <a href="{{ route('role') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fi fi-users float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">ตำแหน่งผู้ดูแลระบบ</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    ตำแหน่งผู้ดูแลระบบ
                                </span>
                            </a>
                        </li>
                        @endif

                        <li class="dropdown-item text-wrap">
                            <a href="#!" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fas fa-history float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">ประวัติการเข้าใข้งาน</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    ข้อมูลการเข้าใช้งานของผู้ใช้
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </li>

    @if(session('_p')['payment_transaction'])
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
                        จัดการรายการการเงินทั้งหมด
                    </p>
                </div>

                <div class="col bg-white overflow-hidden">
                    <ul class="mx-0 px-0 my-2">
                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/transaction/payment') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="far fa-money-bill-alt float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">รายการเคลื่อนไหว</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    รายการเคลื่อนไหวทั้งหมด
                                </span>
                            </a>
                        </li>
                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/transaction/deposit') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fas fa-hand-holding-medical float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">คำร้องการฝากเงิน</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    คำร้องการฝากเงิน 
                                </span>
                            </a>
                        </li>
                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/transaction/transfer') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fas fa-exchange-alt float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">รายการโอนในระบบ</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    รายการโอนในระบบ 
                                </span>
                            </a>
                        </li>
                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/transaction/withdraw') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fas fa-hand-holding-usd float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">การถอนเงิน</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    การถอนเงิน 
                                </span>
                            </a>
                        </li>
                        <li class="dropdown-item text-wrap">
                            <a href="{{ url('/transaction/adjust') }}" class="dropdown-link text-dark transition-hover-start p-3 line-height-1">
                                <i class="fas fa-comment-dollar float-start fs--25 mt--n2"></i>
                                <span class="h5-xs d-block fs--18">Adjust</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    Adjust 
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </li>
    @endif

    <!-- SETTING -->
    <li class="nav-item dropdown">
        <a href="#" class="nav-link nav-link-caret-hide dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainNavFeatures">
            <i class="fas fa-cog float-start m-0 mt-1"></i>
            <span>ตั้งค่า</span> 
        </a>
        <ul class="dropdown-menu dropdown-menu-clean dropdown-menu-hover" aria-labelledby="mainNavHome">
            <li class="dropdown-item dropdown">
                <a class="dropdown-link" href="#!" data-toggle="dropdown">
                    <i class="fas fa-university"></i> ธนาคาร
                </a>
                <ul class="dropdown-menu dropdown-menu-hover shadow-primary-xs">
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="{{ route('cbank') }}" >
                            บัญชีธนาคาร
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="{{ route('bankgroups') }}" >
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
            <li class="dropdown-item dropdown">
                 <a class="dropdown-link js-stoppropag" href="#!" data-toggle="dropdown">
                    <i class="fas fa-desktop"></i> ตั้งค่าหน้าเว็บ
                </a>
                <ul class="dropdown-menu dropdown-menu-hover shadow-primary-xs">
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="#!" >
                            ทั่วไป
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="#!" >
                            Banner
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="{{ route('setting-maintenance-index') }}" >
                            ปรับปรุงระบบ
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown-item dropdown">
                 <a class="dropdown-link js-stoppropag" href="#!" data-toggle="dropdown">
                    <i class="far fa-bell"></i> ตั้งค่าการแจ้งเตือน
                </a>
                <ul class="dropdown-menu dropdown-menu-hover shadow-primary-xs">
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="#!" >
                            LINE Notification
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="#!" >
                            SMS
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown-item dropdown">
                 <a class="dropdown-link js-stoppropag" href="#!" data-toggle="dropdown">
                    <i class="fas fa-plug"></i> API
                </a>
                <ul class="dropdown-menu dropdown-menu-hover shadow-primary-xs">
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="{{ route('setting-api-game-index') }}" >
                            เกม
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="{{ route('setting-api-userlevel-index') }}" >
                            กลุ่มลูกค้า
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>

    <li class="nav-item dropdown">
        <a href="#!" class="nav-link dropdown-toggle js-stoppropag" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainNavHome">
            <i class="fas fa-chart-pie float-start m-0 mt-1"></i>
            <span>รายงาน</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-clean dropdown-menu-hover" aria-labelledby="mainNavHome">
            <li class="dropdown-item">
                <a class="dropdown-link" href="{{ route('reports') }}" >
                    รายงานทั้งหมด
                </a>
            </li>
            <li class="dropdown-item">
                <a class="dropdown-link" href="{{ url('/reports/games/index') }}" >
                    รายงานเกมทั้งหมด
                </a>
            </li>
            <!-- <li class="dropdown-item">
                <a class="dropdown-link" href="{{ url('/reports/pgsoft') }}" >
                    รายงานเกม PG Slot
                </a>
            </li> -->
        </ul>
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
    <!-- END Game -->

    @if(session('_p')['adjust'])
    <li class="nav-item dropdown">
        <a href="{{ route('adjust-index') }}" class="nav-link">
            <i class="fi fi-shield-ok float-start m-0"></i>
            <span>ADJUST FOR ADMIN</span> 
        </a>
    </li>
    @endif

</ul>
</div>