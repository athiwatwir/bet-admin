@extends('layouts.core')

@section('title', 'Account Settings')

@section('content')
<form novalidate class="bs-validate d-block mb-5" method="post" action="/account-setting/update/{{ Auth::user()->id }}" enctype="multipart/form-data">
	@csrf
    <div class="row gutters-sm">
        
        <div class="col-12 col-xl-6 mb-3">

            <!-- portlet -->
            <div class="portlet">

                <!-- portlet : header -->
                <div class="portlet-header">
                    <span class="d-block text-dark text-truncate font-weight-medium">
                        Account Detail
                    </span>
                </div>
                <!-- /portlet : header -->


                <!-- portlet : body -->
                <div class="portlet-body">

                    <div class="row h-100 d-flex align-items-center">

                        <!-- avatar -->
                        <div class="col-12 col-md-4 col-xl-4 text-center">

                            <!-- 
                                Based on `SOW : File Upload` 
                                
                                For ajax:
                                documentation/plugins-sow-file-upload.html 
                            -->
                            <label class="w--120 h--120 rounded-circle text-center position-relative d-inline-block cursor-pointer border border-secondary border-dashed bg-white">

                                <!-- remove button -->
                                <a href="#" class="js-file-upload-avatar-circle-remove hide position-absolute absolute-top w-100 z-index-3">
                                    <span class="d-inline-block btn btn-sm btn-pill bg-secondary text-white pt--4 pb--4 pl--10 pr--10 m--1 mt--n15" title="remove" data-tooltip="tooltip">
                                        <i class="fi fi-close m-0"></i>
                                    </span>
                                </a>

                                <span class="z-index-2 js-file-input-avatar-circle-container d-block absolute-full z-index-1 hide-empty"><!-- avatar container --></span>

                                <!-- hidden input (out of viewport, or safari will ignore it) -->
                                <!-- NOTE: data-file-preview-img-height="118 and <label> has .h--120 (120px). This is because we have a border - so we cut 2px (1px for each side) -->
                                <input	name="account_avatar" 
                                        type="file" 

                                        data-file-ext="jpg, png" 
                                        data-file-max-size-kb-per-file="1024"
                                        data-file-ext-err-msg="Allowed:" 
                                        data-file-size-err-item-msg="File too large!"
                                        data-file-size-err-total-msg="Total allowed size exceeded!"
                                        data-file-toast-position="bottom-center"
                                        data-file-preview-container=".js-file-input-avatar-circle-container" 
                                        data-file-preview-show-info="false" 
                                        data-file-preview-class="rounded-circle m-0 p-0 animate-bouncein" 
                                        data-file-preview-img-height="118" 
                                        data-file-btn-clear="a.js-file-upload-avatar-circle-remove"
                                        data-file-preview-img-cover="true"
                                        class="custom-file-input absolute-full"
                                        style="cursor: pointer;">

                                <svg class="fill-gray-500 rounded-circle m-4 z-index-0" viewBox="0 0 60 60">
                                    <path d="M41.014,45.389l-9.553-4.776C30.56,40.162,30,39.256,30,38.248v-3.381c0.229-0.28,0.47-0.599,0.719-0.951c1.239-1.75,2.232-3.698,2.954-5.799C35.084,27.47,36,26.075,36,24.5v-4c0-0.963-0.36-1.896-1-2.625v-5.319c0.056-0.55,0.276-3.824-2.092-6.525C30.854,3.688,27.521,2.5,23,2.5s-7.854,1.188-9.908,3.53c-2.368,2.701-2.148,5.976-2.092,6.525v5.319c-0.64,0.729-1,1.662-1,2.625v4c0,1.217,0.553,2.352,1.497,3.109c0.916,3.627,2.833,6.36,3.503,7.237v3.309c0,0.968-0.528,1.856-1.377,2.32l-8.921,4.866C1.801,46.924,0,49.958,0,53.262V57.5h46v-4.043C46,50.018,44.089,46.927,41.014,45.389z"></path>
                                    <path d="M55.467,46.526l-9.723-4.21c-0.23-0.115-0.485-0.396-0.704-0.771l6.525-0.005c0,0,0.377,0.037,0.962,0.037c1.073,0,2.638-0.122,4-0.707c0.817-0.352,1.425-1.047,1.669-1.907c0.246-0.868,0.09-1.787-0.426-2.523c-1.865-2.654-6.218-9.589-6.354-16.623c-0.003-0.121-0.397-12.083-12.21-12.18c-1.187,0.01-2.309,0.156-3.372,0.413c0.792,2.094,0.719,3.968,0.665,4.576v4.733c0.648,0.922,1,2.017,1,3.141v4c0,1.907-1.004,3.672-2.607,4.662c-0.748,2.022-1.738,3.911-2.949,5.621c-0.15,0.213-0.298,0.414-0.443,0.604v2.86c0,0.442,0.236,0.825,0.631,1.022l9.553,4.776c3.587,1.794,5.815,5.399,5.815,9.41V57.5H60v-3.697C60,50.711,58.282,47.933,55.467,46.526z"></path>
                                </svg>

                            </label>
                            <small class="d-block">click to upload</small>

                        </div>
                        <!-- /avatar -->

                        <div class="col my-3">

                            <!-- EMAIL ADDRESS -->
                            <div class="input-group-over">

                                <div class="form-label-group">
                                    <input required readonly placeholder="Email Address" id="account_email" name="account_email" type="email" class="form-control" value="{{ Auth::user()->email }}">
                                    <label for="account_email"><span class="text-danger">Email</span> Address</label>
                                </div>

                                <a id="email_edit_show" href="#!" class="btn transition-none sow-util-action" 
                                    data-util-self-ignore="true" 
                                    data-util-target-hide="#email_edit_show" 
                                    data-util-target-show="#email_edit_hide, #email_edit_password_request" 
                                    data-util-target-readonly-off="#account_email" 

                                    data-util-target-input="#account_email" 
                                    data-util-target-input-val="" 

                                    data-util-target-focus="#account_email">
                                    <i class="fi fi-pencil m-0"></i>
                                </a>

                                <a id="email_edit_hide" href="#!" class="btn transition-none sow-util-action hide" 
                                    data-util-self-ignore="true" 
                                    data-util-target-hide="#email_edit_hide, #email_edit_password_request" 
                                    data-util-target-show="#email_edit_show" 
                                    data-util-target-readonly-on="#account_email" 

                                    data-util-target-input="#account_email" 
                                    data-util-target-input-val="{{ Auth::user()->email }}">
                                    <i class="fi fi-close m-0"></i>
                                </a>

                            </div>

                            <div id="email_edit_password_request" class="mt-3 hide">

                                <!-- password -->
                                <div class="input-group-over">
                                    <div class="form-label-group mb-3">
                                        <input placeholder="Account Password" id="account_password" name="account_email_password" type="password" class="form-control">
                                        <label for="account_password">Account Password</label>
                                    </div>

                                    <!-- Show Password -->
                                    <a href="#" class="btn btn-password-type-toggle" data-target="#account_password">
                                        <span class="group-icon">
                                            <i class="fi fi-eye m-0"></i>
                                            <i class="fi fi-close m-0"></i>
                                        </span>
                                    </a>
                                </div>
                                <!-- /password -->

                            </div>
                            <!-- /EMAIL ADDRESS -->

                        </div>

                    </div>

                </div>
                <!-- /portlet : body -->

            </div>
            <!-- /portlet -->

        </div>




        <div class="col-12 col-xl-6 mb-3">

            <!-- portlet -->
            <div class="portlet">

                <!-- portlet : header -->
                <div class="portlet-header">
                    <span class="d-block text-dark text-truncate font-weight-medium">
                        Personal Detail
                    </span>
                </div>
                <!-- /portlet : header -->


                <!-- portlet : body -->
                <div class="portlet-body">

                    <div class="row gutters-sm d-flex align-items-center">

                        <div class="col-12 col-md-12">

                            <div class="form-label-group mt-3">
                                <input required placeholder="First Name" id="account_first_name" name="account_name" type="text" value="{{ Auth::user()->name }}" class="form-control">
                                <label for="account_first_name">Name</label>
                                @error('account_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="col-12 col-md-6">

                            <div class="form-label-group mt-3">
                                <input placeholder="Company Name" id="account_company_name" name="account[company_name]" type="text" value="" class="form-control">
                                <label for="account_company_name">Company Name</label>
                            </div>

                        </div>

                        <div class="col-12 col-md-6">

                            <div class="form-label-group mt-3">
                                <input placeholder="Phone Number" id="account_phone_number" name="account[phone_number]" type="text" value="" class="form-control">
                                <label for="account_phone_number">Phone Number</label>
                            </div>

                        </div>

                        <div class="col-12">

                            <div class="form-label-group mt-3">
                                <input placeholder="Address" id="account_address" name="account[address]" type="text" value="" class="form-control">
                                <label for="account_address">Address</label>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- /portlet : body -->

            </div>
            <!-- /portlet -->

        </div>

    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fi fi-check"></i>
        Save Changes
    </button>

</form>





<!-- PASSWORD RESET -->
<div class="row gutters-sm mb-3">
    
    <div class="col-12 mb-3">


        <!-- portlet -->
        <div class="portlet">

            <!-- portlet : body -->
            <div class="portlet-body">

                <a id="passwordResetToggler" href="#passwordForm" data-toggle="collapse" class="btn-toggle btn btn-light scroll-to" data-offset="-300" data-speed="600" data-toggle-target="#passwordResetToggler" data-toggle-container-class="hide">
                    <i class="fi fi-locked"></i>
                    Reset Password
                </a>

                <div id="passwordForm" class="collapse">

                    <form novalidate class="bs-validate row" method="post" action="/account-setting/change-password/{{ Auth::user()->id }}">
                    @csrf
                        <div class="col-12 col-md-6 mb-3">
            
                            <!-- portlet : header -->
                            <div class="portlet-header pt-0 pb-5">
                                <span class="d-block text-dark text-truncate font-weight-medium">
                                    Account Password
                                </span>
                            </div>
                            <!-- /portlet : header -->

                            <div class="row gutters-sm">

                                <div class="col-12 col-xl-6 mb-3">

                                    <!-- current password -->
                                    <div class="input-group-over">
                                        <div class="form-label-group mb-3">
                                            <input required placeholder="Current Password" id="account_current_password" name="account_current_password" type="password" class="form-control">
                                            <label for="account_current_password">
                                                รหัสผ่าน<span class="text-danger">เดิม</span>
                                            </label>
                                        </div>

                                        <!-- Show Password -->
                                        <a href="#" class="btn btn-password-type-toggle" data-target="#account_current_password" tabindex="-1">
                                            <span class="group-icon">
                                                <i class="fi fi-eye m-0"></i>
                                                <i class="fi fi-close m-0"></i>
                                            </span>
                                        </a>
                                    </div>
                                    <!-- /current password -->

                                </div>

                                <div class="col-12 col-xl-6 mb-3">

                                    <!-- new password -->
                                    <div class="input-group-over">
                                        <div class="form-label-group mb-3">
                                            <input required placeholder="New Password" id="account_new_password" name="account_new_password" type="password" class="form-control">
                                            <label for="account_new_password">
                                                รหัสผ่าน<span class="text-danger">ใหม่</span>
                                            </label>
                                        </div>

                                        <!-- Show Password -->
                                        <a href="#" class="btn btn-password-type-toggle" data-target="#account_new_password" tabindex="-1">
                                            <span class="group-icon">
                                                <i class="fi fi-eye m-0"></i>
                                                <i class="fi fi-close m-0"></i>
                                            </span>
                                        </a>
                                    </div>
                                    <!-- /new password -->

                                </div>

                            </div>


                            <button type="submit" class="btn btn-warning mb-3 d-block-xs w-100-xs">
                                <i class="fi fi-check"></i>
                                Update Password
                            </button>


                            <a id="passwordResetCancel" href="#passwordForm" data-toggle="collapse" class="btn-toggle btn btn-light mb-3 d-block-xs w-100-xs" data-toggle-temporized="10" data-toggle-target="#passwordResetToggler" data-toggle-container-class="hide active">
                                <i class="fi fi-close"></i>
                                Cancel
                            </a>

                        </div>

                        <div class="col-12 col-md-6">

                            <div class="w-100 h-100 bg-light rounded p-4 text-center-xs d-flex align-items-center">
                                
                                <div class="w-100 text-center-xs">

                                    <h6>
                                        Can't remember your current password?
                                    </h6>
                                    <a	href="#!" 
                                        class="btn-toggle btn btn-primary btn-soft" 
                                        data-toggle-temporized="5000" 
                                        data-toggle-ajax-url-on="../../html_frontend/demo.files/php/demo.ajax_request.php?action=pass_reset" 
                                        data-toast-success-message="Reset link sent to your email!" 
                                        data-toast-success-position="bottom-center">
                                        <span class="group-icon">
                                            <span>Reset via email</span>
                                            <span>
                                                <i class="fi fi-circle-spin fi-spin"></i>
                                                <span>Reset via email</span>
                                            </span>
                                        </span>
                                    </a>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>
            <!-- /portlet : body -->

        </div>
        <!-- /portlet -->


    </div>

</div>
<!-- /PASSWORD RESET -->
@endsection