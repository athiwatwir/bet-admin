@extends('layouts.core')

@section('title', 'Dashboard')

@section('content')
<!-- Primary -->
<section class="rounded mb-3">


<!-- graph header -->
<div class="clearfix fs--18 pt-2 pb-3 mb-3 border-bottom">

    <!-- save image -->
    <a href="#" data-chartjs-id="visitsvsorders" data-file-name="visitsvsorders" class="btn btn-sm btn-light rounded-circle chartjs-save float-end m-0" title="Save Chart" aria-label="Save Chart">
        <i class="fi fi-arrow-download m-0"></i>
    </a>
    <!-- /save image -->

    2020 Orders
    <small class="fs--12 text-muted d-block mt-1">MONTHLY REVENUE OF 2020</small>

</div>
<!-- /graph header -->



<div class="row gutters-sm">

    <!-- MAIN GRAPH -->
    <div class="col-12 col-lg-7 col-xl-9 mb-5">

        <div class="position-relative min-h-250 max-h-500 max-h-300-xs h-100">
        <canvas id="visitsvsorders" class="chartjs" 
            data-chartjs-dots="false" 
            data-chartjs-legend="false" 
            data-chartjs-grid="true" 
            data-chartjs-tooltip="true" 

            data-chartjs-title="" 
            data-chartjs-xaxes-label="" 
            data-chartjs-yaxes-label="" 

            data-chartjs-type="bar" 
            data-chartjs-labels='["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]' 
            data-chartjs-datasets='[{															
                "label": 				"Visits",
                "data": 				[20, 22, 24, 21, 23, 26, 24, 23, 21, 24, 23, 22],
                "fill": 				false,
                "backgroundColor": 		"rgb(139, 195, 74, 0.35)"
            }]'></canvas>

        </div>

    </div>
    <!-- /MAIN GRAPH -->

    <div class="col-12 col-lg-5 col-xl-3">

        <!-- card -->
        <div class="bg-white shadow-lg p-4 rounded my-3 transition-hover-top transition-all-ease-150">

            <!-- dropdown options -->
            <div class="float-end dropdown">

                <!-- dropdown -->
                <button type="button" class="dropdown-toggle btn btn-sm btn-soft btn-primary px-2 py-1 fs--15 mt--n3" aria-label="Dropdown Options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fi fi-dots-vertical m-0"></i>
                </button>

                <div class="prefix-link-icon prefix-icon-dot dropdown-menu dropdown-menu-invert mt-2">

                    <a href="#!" class="dropdown-item">
                        Export PDF
                    </a>

                    <a href="#!" class="dropdown-item">
                        Export Tasks
                    </a>

                    <a href="#!" class="dropdown-item">
                        Print
                    </a>

                </div>
                <!-- /dropdown -->

            </div>
            <!-- /dropdown options -->


            <div class="mb-3">
                <a href="#!" class="w--40 h--40 rounded-circle d-inline-block bg-light bg-cover lazy" data-background-image="../../html_frontend/demo.files/images/unsplash/team/thumb_330/erik-mclean-06vpBIHmiYc-unsplash.jpg"></a>
                <a href="#!" class="w--40 h--40 rounded-circle d-inline-block bg-light bg-cover lazy" data-background-image="../../html_frontend/demo.files/images/unsplash/team/thumb_330/craig-mckay-jmURdhtm7Ng-unsplash.jpg"></a>
                <a href="#!" class="w--40 h--40 rounded-circle d-inline-block bg-light bg-cover lazy" data-background-image="../../html_frontend/demo.files/images/unsplash/team/thumb_330/michael-dam-mEZ3PoFGs_k-unsplash.jpg"></a>
            </div>

            <a href="#!" class="h6 text-dark">
                Project Ikarus
            </a>

            <p class="font-weight-light fs--14">This project has a timeline, we need to finish it as soon as possible!</p>

            <span class="fs--14">39%</span>
            <div class="progress h--2">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 39%" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

        </div>


        <!-- card -->
        <div class="bg-white shadow-lg p-4 rounded my-3 transition-hover-top transition-all-ease-150">

            <!-- dropdown options -->
            <div class="float-end dropdown">

                <!-- dropdown -->
                <button type="button" class="dropdown-toggle btn btn-sm btn-soft btn-primary px-2 py-1 fs--15 mt--n3" aria-label="Dropdown Options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fi fi-dots-vertical m-0"></i>
                </button>

                <div class="prefix-link-icon prefix-icon-dot dropdown-menu dropdown-menu-invert mt-2">

                    <a href="#!" class="dropdown-item">
                        Export PDF
                    </a>

                    <a href="#!" class="dropdown-item">
                        Export Tasks
                    </a>

                    <a href="#!" class="dropdown-item">
                        Print
                    </a>

                </div>
                <!-- /dropdown -->

            </div>
            <!-- /dropdown options -->


            <div class="mb-3">
                <a href="#!" class="w--40 h--40 rounded-circle d-inline-block bg-light bg-cover lazy" data-background-image="../../html_frontend/demo.files/images/unsplash/team/thumb_330/joseph-gonzalez-iFgRcqHznqg-unsplash.jpg"></a>
                <a href="#!" class="w--40 h--40 rounded-circle d-inline-block bg-light bg-cover lazy" data-background-image="../../html_frontend/demo.files/images/unsplash/team/thumb_330/sage-kirk-Wx2AjoLtpcU-unsplash.jpg"></a>
            </div>

            <a href="#!" class="h6 text-dark">
                Remarketing
            </a>

            <p class="font-weight-light fs--14">
                Our client needs remarketing for his two projects!
            </p>

            <span class="fs--14">78%</span>
            <div class="progress h--2">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

        </div>






        <div class="clearfix bg-light p-1 row-pill">
            <a href="#!" class="btn btn-pill btn-sm btn-warning py-1 mb-0 float-start transition-hover-end" title="Detailed Revenue" aria-label="Detailed Revenue">View</a>
            <span class="d-block pt-1 pl-2 pr-2 text-muted text-truncate">
                view all projects
            </span>
        </div>

    </div>

</div>

</section>
<!-- /Primary -->

<!-- WIDGETS -->
<div class="row gutters-sm">

<div class="col-12 col-md-6 col-xl-3 mb-3">

    <!-- small graph widget -->
    <div class="bg-white shadow-md text-dark p-5 rounded text-center">

        <span class="badge badge-light fs--45 w--100 h--100 badge-pill rounded-circle">
            <i class="fi fi-user-plus mt-1"></i>
        </span>

        <h3 class="fs--20 mt-5">
            New Customers
        </h3>

        <p>
            Last 30 days
        </p>

        <div class="position-relative max-h-200">
            <canvas class="chartjs" 
                data-chartjs-dots="false" 
                data-chartjs-legend="false" 
                data-chartjs-grid="false" 
                data-chartjs-tooltip="true" 

                data-chartjs-line-width="3" 
                data-chartjs-type="line" 

                data-chartjs-labels='["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]' 
                data-chartjs-datasets='[{                                                           
                    "label":                    "Customers",
                    "data":                     [11, 11, 17, 11, 15, 12, 13, 12, 11, 12, 7, 8],
                    "fill":                     false,
                    "backgroundColor":          "rgba(255, 159, 64, 1)"
                }]'
            ></canvas>
        </div>

    </div>
    <!-- /small graph widget -->

</div>



<div class="col-12 col-md-6 col-xl-3 mb-3">

    <!-- small graph widget -->
    <div class="bg-white shadow-md text-dark p-5 rounded text-center">

        <span class="badge badge-light fs--45 w--100 h--100 badge-pill rounded-circle">
            <i class="fi fi-cart-1 mt-1"></i>
        </span>

        <h3 class="fs--20 mt-5">
            Monthly Orders
        </h3>

        <p>
            Last 30 days
        </p>

        <div class="position-relative max-h-200">
            <canvas class="chartjs" 
                data-chartjs-dots="false" 
                data-chartjs-legend="false" 
                data-chartjs-grid="false" 
                data-chartjs-tooltip="true" 

                data-chartjs-line-width="3" 
                data-chartjs-type="line" 

                data-chartjs-labels='["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]' 
                data-chartjs-datasets='[{                                                           
                    "label":                    "Orders",
                    "data":                     [11, 11, 17, 11, 15, 12, 13, 16, 11, 18, 20, 21],
                    "fill":                     false,
                    "backgroundColor":          "rgba(54, 162, 235, 1)"
                }]'
            ></canvas>
        </div>

    </div>
    <!-- /small graph widget -->
    
</div>




<div class="col-12 col-xl-6 mb-3">


    <div class="portlet">
        
        <div class="portlet-header">

            <div class="float-end dropdown">

                <!-- dropdown -->
                <button type="button" class="dropdown-toggle btn btn-sm btn-soft btn-primary px-2 py-1 fs--15 mt--n3" id="dropdownGraph1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fi fi-dots-vertical m-0"></i>
                </button>

                <div class="prefix-link-icon prefix-icon-dot dropdown-menu dropdown-menu-invert mt-2" aria-labelledby="dropdownGraph1">

                    <div class="dropdown-header">
                        Export Options
                    </div>

                    <a href="#!" class="dropdown-item">
                        Export CSV
                    </a>

                    <a href="#!" class="dropdown-item">
                        Export XLS
                    </a>

                    <a href="#!" class="dropdown-item">
                        Export PDF
                    </a>

                    <a href="#!" class="dropdown-item">
                        Print
                    </a>

                </div>
                <!-- /dropdown -->

            </div>

            <span class="d-block text-muted text-truncate font-weight-medium">
                Monthly Conversions
            </span>
        </div>

        <div class="portlet-body max-h-500 scrollable-vertical scrollable-styled-dark tab-content">


        <div class="position-relative min-h-250 max-h-300-xs h-100">
            <canvas class="chartjs" 
                data-chartjs-dots="false" 
                data-chartjs-legend="false" 
                data-chartjs-grid="true" 
                data-chartjs-tooltip="true" 

                data-chartjs-line-width="3" 
                data-chartjs-type="line" 

                data-chartjs-labels='["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]' 
                data-chartjs-datasets='[{                                                           
                    "label":                    "Orders",
                    "data":                     [11, 11, 17, 11, 15, 12, 13, 16, 11, 18, 20, 21],
                    "fill":                     true,
                    "backgroundColor":          "rgba(201, 203, 207, 0.3)",
                    "borderColor": 				"rgba(255, 99, 132, 1)",
                    "borderWidth": 1
                }]'
            ></canvas>
        </div>


        </div>

    </div>


    
</div>


</div>
<!-- /WIDGETS -->
@endsection
