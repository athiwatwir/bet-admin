@extends('layouts.login')

@section('content')
<div class="d-lg-flex text-white min-h-100vh bg-gradient-purple overlay-dark overlay-opacity-5">

    <div class="col-12 col-lg-5 d-lg-flex">
        <div class="w-100 align-self-center">


            <div class="py-7">
                <h1 class="d-inline-block text-align-end text-center-md text-center-xs display-4 h2-xs w-100 max-w-600 w-100-md w-100-xs">
                    Sign in
                    <span class="display-3 h1-xs d-block font-weight-medium">
                        .......
                    </span>
                </h1>
            </div>


        </div>
    </div>


    <div class="col-12 col-lg-7 d-lg-flex">
        <div class="w-100 align-self-center text-center-md text-center-xs py-2">

            <!-- optional class: .form-control-pill -->
            <form method="POST" action="{{ url('/login') }}" class="bs-validate p-5 py-6 rounded d-inline-block bg-white text-dark w-100 max-w-600">
                @csrf

                <!--
                <p class="text-danger">
                    Ups! Please check again
                </p>
                -->

                <div class="form-label-group mb-3">
                    <input id="username" placeholder="Username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus>
                    <label for="username">Username</label>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                </div>

                <div class="input-group-over">
                    <div class="form-label-group mb-3">
                        <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <label for="password">Password</label>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        
                    </div>

                    <!-- <a href="account-signin-password.html" class="btn fs--12">
                        FORGOT?
                    </a> -->

                </div>



                <div class="row">
                    <div class="col-12 col-md-6 offset-md-6 mt-4">
                        <button type="submit" class="btn btn-purple btn-block transition-hover-top">
                            Sign In
                        </button>
                    </div>
                </div>

            </form>


            <!-- cookie alert
            <div class="alert bg-white text-dark p-3 my-2 b-0 rounded d-inline-block w-100 max-w-600">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span class="fi fi-close" aria-hidden="true"></span>
                </button>
                Smarty uses cookies for best experience! <a href="#!" class="link-muted">Learn more</a>
            </div>
            -->

        </div>
    </div>
</div>
@endsection
