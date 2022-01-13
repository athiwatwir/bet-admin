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
							<strong>เลือกรายงาน</strong>
							<select class="form-control" name="type">
								@foreach($reportTypes as $key => $type)
                                    <option value="{{ $key }}">{{ $type }}</option>
                                @endforeach
							</select>
						</div>
						<div class="col-12 col-md-3 form-group">
							<strong>จากวันที่</strong>
							<x-input-date-picker name="startdate" />
						</div>

						<div class="col-12 col-md-3 form-group">
							<strong>ถึงวันที่</strong>
							<x-input-date-picker name="enddate" />
						</div>
						<div class="col-12 col-md-2 form-group">
							<label></label>
							<button class="btn btn-primary btn-block" type="submit"><i class="fas fa-search mr-1"></i> ค้นหา</button>
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