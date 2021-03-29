<li class="list-inline-item ml--6 mr--6 dropdown">

    <a href="#" id="dropdownAccountOptions" class="btn btn-sm btn-light dropdown-toggle btn-pill pl--12 pr--12" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
        
        <span class="group-icon m-0">
            <i class="fi w--15 fi-user-male"></i>
            <i class="fi w--15 fi-close"></i>
        </span>

        <span class="fs--14 d-none d-sm-inline-block font-weight-medium">{{ Auth::user()->name }}</span>
    </a>
    <div aria-labelledby="dropdownAccountOptions" class="prefix-link-icon prefix-icon-dot dropdown-menu dropdown-menu-clean dropdown-menu-navbar-autopos dropdown-menu-invert dropdown-click-ignore p-0 mt--18 fs--15 w--300">
        
        <div class="dropdown-header fs--14 py-4">

            <!-- profile image -->
            <div class="w--60 h--60 rounded-circle bg-light bg-cover float-start" style="background-image:url('../../html_frontend/demo.files/images/icons/user80.png')"></div>

            <!-- user detail -->
            <span class="d-block font-weight-medium text-truncate fs--16">{{ Auth::user()->name }}</span>
            <span class="d-block text-muted font-weight-medium text-truncate">{{ Auth::user()->email }}</span>
            <small class="d-block text-muted"><b>Last Login:</b> 2019-09-03 01:48</small>

        </div>

        <div class="dropdown-divider"></div>

        <a href="#!" target="_blank" class="dropdown-item text-truncate font-weight-medium">
            Notes
            <small class="d-block text-muted">personal encypted notes</small>
        </a>

        <a href="#!" target="_blank" class="dropdown-item text-truncate font-weight-medium">
            <span class="badge badge-success float-end font-weight-normal mt-1">3 new</span>
            Messages
            <small class="d-block text-muted">internal messaging system</small>
        </a>

        <a href="#!" target="_blank" class="dropdown-item text-truncate font-weight-medium">
            <span class="badge badge-danger float-end font-weight-normal mt-1">1 unpaid</span>
            Invoices
            <small class="d-block text-muted">montly billing</small>
        </a>

        <a href="{{ url('/account-setting') }}" class="dropdown-item text-truncate font-weight-medium">
            Account Settings
            <small class="d-block text-muted">profile, password and more...</small>
        </a>

        <div class="dropdown-divider mb-0"></div>

        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

</li>