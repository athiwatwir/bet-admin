<!-- NAVIGATION -->
<div class="collapse navbar-collapse px-5 pl-0-xs pr-0-xs" id="navbarMainNav">

@include('layouts.header.logo_mobile')

<!-- Dropdowns -->
<ul class="navbar-nav align-items-center">

    <!-- Features -->
    <li class="nav-item dropdown">

        <a href="#" class="nav-link nav-link-caret-hide dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainNavFeatures">
            <i class="fi fi-shield-ok float-start m-0"></i>
            <span>Upgrade</span>
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
                                <span class="h5-xs d-block fs--18">Startup Go</span>
                                <span class="fs--11 text-muted text-uppercase">
                                    STARTING WITH $29 / mo
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


    <!--  -->
    <li class="nav-item dropdown">

        <a href="#!" class="nav-link nav-link-caret-hide dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainNavApps">
            <i class="fi fi-squared-dots float-start m-0"></i>
            <span>Apps</span>
        </a>

        <div class="dropdown-menu dropdown-menu-clean dropdown-menu-hover w--280 p-0 overflow-hidden" aria-labelledby="mainNavApps">

            <div class="bg-white">

                <!-- apps list -->
                <div class="max-h-50vh scrollable-vertical">
                    <div class="overflow-hidden">
                        <div class="row row-grid no-gutters p-0 m-0 list-unstyled b-0 ml--n1 mr--n1">

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-support d-block fs--40"></i>
                                    <span class="d-block fs--15">Support</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-24 d-block fs--40"></i>
                                    <span class="d-block fs--15">Monitoring</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-database d-block fs--40"></i>
                                    <span class="d-block fs--15">Databases</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-calendar d-block fs--40"></i>
                                    <span class="d-block fs--15">Calendar</span>
                                    <!-- badge -->
                                    <span class="badge badge-danger shadow-danger-md animate-pulse fs--10 p-1 m-2 position-absolute end-0 top-0">1</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-code d-block fs--40"></i>
                                    <span class="d-block fs--15">Live Code</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-chart-up d-block fs--40"></i>
                                    <span class="d-block fs--15">Stats</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-envelope d-block fs--40"></i>
                                    <span class="d-block fs--15">Email</span>
                                    <!-- badge -->
                                    <span class="badge badge-success fs--10 p-1 m-2 position-absolute end-0 top-0">12</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-list-checked d-block fs--40"></i>
                                    <span class="d-block fs--15">Tasks</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-truck-speed d-block fs--40"></i>
                                    <span class="d-block fs--15">Delivery</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-gift d-block fs--40"></i>
                                    <span class="d-block fs--15">Gifts</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-attachment d-block fs--40"></i>
                                    <span class="d-block fs--15">Attachments</span>
                                    <!-- badge -->
                                    <span class="badge badge-secondary fs--10 p-1 m-2 position-absolute end-0 top-0">115</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-image d-block fs--40"></i>
                                    <span class="d-block fs--15">Cloud Images</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-time d-block fs--40"></i>
                                    <span class="d-block fs--15">Alarams</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-percent d-block fs--40"></i>
                                    <span class="d-block fs--15">Discounts</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-heart-slim d-block fs--40"></i>
                                    <span class="d-block fs--15">Favourites</span>
                                </a>
                            </div>

                            <div class="col-6">
                                <a href="#!" class="dropdown-link text-dark text-center d-block transition-all-ease-250 shadow-primary-xs-hover p-2">
                                    <i class="fi fi-umbrella d-block fs--40"></i>
                                    <span class="d-block fs--15">Umbrella</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /apps list -->

                <div class="bg-theme-color-light shadow-dark-xs">

                    <ul class="mx-0 px-0">

                        <li class="dropdown-item text-wrap bg-transparent px-2 py-1">
                            <a href="#!" class="dropdown-link bg-transparent text-dark py-3 px-3">
                                <i class="fi fi-plus"></i>
                                App Library
                            </a>
                        </li>

                    </ul>

                </div>


            </div>

        </div>

    </li>



    <!--  -->
    <li class="nav-item dropdown">

        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainNavHome">
            Shortcuts
        </a>

        <ul class="dropdown-menu dropdown-menu-clean dropdown-menu-hover" aria-labelledby="mainNavHome">

            <li class="dropdown-item dropdown">
                <a class="dropdown-link" href="#!" data-toggle="dropdown">
                    <i class="fi fi-cart-1"></i>
                    Components
                </a>

                <ul class="dropdown-menu dropdown-menu-hover b-0 m-0 shadow-primary-xs">
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="components-alerts.html">
                            <i class="fi fi-plus"></i>
                            Alerts
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="components-accordions.html">
                            <i class="fi fi-list-checked"></i>
                            Accordions
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="components-badges.html">
                            <i class="fi fi-box"></i>
                            Badges
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <a class="dropdown-link" href="components-buttons.html">
                            <i class="fi fi-close"></i>
                            Buttons
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <a class="dropdown-link" target="_blank" href="../../html_frontend/documentation/plugins-sow-ajax-forms.html">
                            <i class="fi fi-close"></i>
                            Documentation
                        </a>
                    </li>
                </ul>

            </li>
            <li class="dropdown-item">
                <a class="dropdown-link" href="account-signin.html">
                    <i class="fi fi-user-plus"></i>
                    Sign In/Up
                </a>
            </li>
            <li class="dropdown-item">
                <a class="dropdown-link" href="account-settings.html">
                    <i class="fi fi-users"></i>
                    Account Settings
                </a>
            </li>
            <li class="dropdown-item">
                <a class="dropdown-link" href="admin-staff.html">
                    <i class="fi fi-graph"></i>
                    Admin Staff
                </a>
            </li>
            <li class="dropdown-item">
                <a class="dropdown-link" href="page-list.html">
                    <i class="fi fi-task-list"></i>
                    Page List
                </a>
            </li>
            <li class="dropdown-item">
                <a class="dropdown-link" href="page-product-add.html">
                    <i class="fi fi-task-list"></i>
                    Product Add
                </a>
            </li>
            <li class="dropdown-item">
                <a class="dropdown-link" href="message-inbox.html">
                    <i class="fi fi-task-list"></i>
                    Message Inbox
                </a>
            </li>
            <li class="dropdown-item">
                <a class="dropdown-link" target="_blank" href="../../html_frontend/documentation/plugins-sow-ajax-forms.html">
                    <i class="fi fi-task-list"></i>
                    Documentation
                </a>
            </li>
        </ul>

    </li>

    <li class="nav-item dropdown dropdown-mega">

        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainMegaNav">
            Mega
        </a>

        <ul class="dropdown-menu dropdown-menu-clean dropdown-menu-hover shadow-primary-xs" aria-labelledby="mainMegaNav">
            <li class="dropdown-item bg-transparent">
                
                <!-- 
                    for 5 columns:  
                    .col-md-5th   -instead of-   .col-md-3 
                -->
                <div class="row col-border-md">

                    <div class="col-12 col-md-3">

                        <h3 class="h6 text-muted text-uppercase fs--14 mb-3">DOTS</h3>
                        <ul class="prefix-link-icon prefix-icon-dot">

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="#!">Option 1</a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="#!">Option 2</a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="#!">Option 3</a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="#!">Option 4</a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="#!">Option 5</a>
                            </li>

                        </ul>

                    </div>

                    <div class="col-12 col-md-3">

                        <h3 class="h6 text-muted text-uppercase fs--14 mb-3">LINES</h3>
                        <ul class="prefix-link-icon prefix-icon-line">

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="#!">Option 1</a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="#!">Option 2</a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="#!">Option 3</a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="#!">Option 4</a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="#!">Option 5</a>
                            </li>

                        </ul>

                    </div>

                    <div class="col-12 col-md-3">

                        <h3 class="h6 text-muted text-uppercase fs--14 mb-3">ICONS</h3>
                        <ul class="prefix-link-icon prefix-icon-ico">

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="../../html_frontend/documentation/components-icons.html">
                                    <i class="fi fi-cart-1"></i>
                                    Option 1
                                </a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="../../html_frontend/documentation/components-icons.html">
                                    <i class="fi fi-user-plus"></i>
                                    Option 2
                                </a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="../../html_frontend/documentation/components-icons.html">
                                    <i class="fi fi-users"></i>
                                    Option 3
                                </a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="../../html_frontend/documentation/components-icons.html">
                                    <i class="fi fi-graph"></i>
                                    Option 4
                                </a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="../../html_frontend/documentation/components-icons.html">
                                    <i class="fi fi-task-list"></i>
                                    Option 5
                                </a>
                            </li>

                        </ul>

                    </div>

                    <div class="col-12 col-md-3">

                        <h3 class="h6 text-muted text-uppercase fs--14 mb-3">ARROWS</h3>
                        <ul class="prefix-link-icon prefix-icon-arrow">

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="#!">Option 1</a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="#!">Option 2</a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="#!">Option 3</a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="#!">Option 4</a>
                            </li>

                            <li class="dropdown-item">
                                <a class="dropdown-link transition-hover-start" href="#!">Option 5</a>
                            </li>

                        </ul>

                    </div>

                </div>

            </li>
        </ul>

    </li>

</ul>
<!-- /Dropdowns -->

</div>
<!-- /NAVIGATION -->