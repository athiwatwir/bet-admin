@extends('layouts.core')
@section('title', 'รายงาน')

@section('content')
<div class="row gutters-sm">
	<div class="col-12 col-md-8 offset-md-2 mb-3 bg-light p-2 rounded">
		<div class="portlet">
			<div class="portlet-body">
				<form method="GET" action="{{ url('/reports/search') }}">
					<div class="row">
						<div class="col-12 col-md-4 form-group">

							<select class="form-control" name="type">
								@foreach($reportTypes as $key => $type)
                                    <option value="{{ $key }}">{{ $type }}</option>
                                @endforeach
							</select>
						</div>
						<div class="col-12 col-md-3 form-group">
							<div class="input-group-over position-realtive z-index-1 bg-white">

								<input type="text" name="startdate" class="form-control bg-transparent datepicker" 
															data-today-highlight="true" 
															data-layout-rounded="true" 
															data-title="" 
															data-show-weeks="true" 
															data-today-highlight="true" 
															data-today-btn="true" 
															data-autoclose="true" 
															data-format="MM/DD/YYYY"
															data-quick-locale='{
																"days": ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
																"daysShort": ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
																"daysMin": ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
																"months": ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
																"monthsShort": ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
																"today": "Today",
																"clear": "Clear",
																"titleFormat": "MM yyyy"}'>

								<span class="fi fi-calendar fs--20 ml-4 mr-4 z-index-n1 text-muted"></span>
							</div>					

						</div>

						<div class="col-12 col-md-3 form-group">
							<div class="input-group-over position-realtive z-index-1 bg-white">

								<input type="text" name="enddate" class="form-control bg-transparent datepicker" 
															data-today-highlight="true" 
															data-layout-rounded="true" 
															data-title="" 
															data-show-weeks="true" 
															data-today-highlight="true" 
															data-today-btn="true" 
															data-autoclose="true" 
															data-format="MM/DD/YYYY"
															data-quick-locale='{
																"days": ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
																"daysShort": ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
																"daysMin": ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
																"months": ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
																"monthsShort": ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
																"today": "Today",
																"clear": "Clear",
																"titleFormat": "MM yyyy"}'>

								<span class="fi fi-calendar fs--20 ml-4 mr-4 z-index-n1 text-muted"></span>
							</div>
						</div>
						<div class="col-12 col-md-2 form-group">
							<button class="btn btn-primary btn-block" type="submit">GO!</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@if(isset($results))
<div class="row gutters-sm">
	<div class="col-12">
		<div class="portlet">
			<div class="portlet-header border-bottom">
				 <strong class="text-dark">{{ $is_report }}  ระหว่างวันที่ {{ date('d-m-Y', strtotime($start)) }} ถึง {{ date('d-m-Y', strtotime($end)) }}</strong>
			</div>
			<!-- /portlet : header -->
			<div class="portlet-body pt-2 px-5">
			@include('reports.transaction_datatable')
			</div>
		</div>
	</div>
</div>
@endif

<style>
	a.dt-button.dropdown-item.buttons-pdf.buttons-html5 {
		display: none;
	}
</style>
@endsection