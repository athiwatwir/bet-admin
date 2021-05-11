<div class="col-12 col-lg-3 col-xl-2">

    <nav class="nav-deep nav-deep-light mb-2">

        <!-- mobile only -->
        <button class="clearfix btn btn-toggle btn-sm btn-block text-align-left shadow-md border rounded mb-1 d-block d-lg-none" data-target="#nav_responsive" data-toggle-container-class="d-none d-sm-block bg-white shadow-md border animate-fadein rounded p-3">
            <span class="group-icon px-2 py-2 float-start">
                <i class="fi fi-bars-2"></i>
                <i class="fi fi-close"></i>
            </span>

            <span class="h5 py-2 m-0 float-start font-weight-light">
                Inbox
            </span>
        </button>


        <!-- navigation -->
        <ul id="nav_responsive" class="nav flex-column d-none d-lg-block">

            <li class="nav-item active">
                <a class="nav-link px-0" href="{{ url('/admins') }}">
                    <i class="fi fi-arrow-end m-0 fs--12"></i> 
                    <span class="px-2 d-inline-block">
                        ผู้ดูแลระบบทั้งหมด
                    </span>
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link px-0" href="{{ url('/admins') }}">
                    <i class="fi fi-arrow-end m-0 fs--12"></i> 
                    <span class="px-2 d-inline-block">
                        ผู้ดูแลระบบที่เปิดใช้งาน
                    </span>
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link px-0" href="{{ url('/admins') }}">
                    <i class="fi fi-arrow-end m-0 fs--12"></i> 
                    <span class="px-2 d-inline-block">
                        ผู้ดูแลระบบที่ปิดใช้งาน
                    </span>
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link px-0" href="{{ url('/admins') }}">
                    <i class="fi fi-arrow-end m-0 fs--12"></i> 
                    <span class="px-2 d-inline-block">
                        ผู้ดูแลระบบที่ถูกลบ
                    </span>
                </a>
            </li>

        </ul>

    </nav>

</div>