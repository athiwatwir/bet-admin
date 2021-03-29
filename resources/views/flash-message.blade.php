@if ($message = Session::get('success'))
<div class="alert alert-success alert-block timer-autohide" role="alert" data-timer-autohide="4000">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span class="fi fi-close" aria-hidden="true"></span>
    </button>  
    <strong>{{ $message }}</strong>
</div>
@endif
  
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block timer-autohide" role="alert" data-timer-autohide="4000">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span class="fi fi-close" aria-hidden="true"></span>
    </button>   
    <strong>{{ $message }}</strong>
</div>
@endif
   
@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block timer-autohide" role="alert" data-timer-autohide="4000">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span class="fi fi-close" aria-hidden="true"></span>
    </button>  
    <strong>{{ $message }}</strong>
</div>
@endif
   
@if ($message = Session::get('info'))
<div class="alert alert-info alert-block timer-autohide" role="alert" data-timer-autohide="4000">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span class="fi fi-close" aria-hidden="true"></span>
    </button>    
    <strong>{{ $message }}</strong>
</div>
@endif
  
@if ($errors->any())
<div class="alert alert-danger timer-autohide" role="alert" data-timer-autohide="4000">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span class="fi fi-close" aria-hidden="true"></span>
    </button>  
    Please check the form below for errors
</div>
@endif