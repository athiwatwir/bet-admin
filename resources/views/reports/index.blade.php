@extends('layouts.core')
@section('title', 'รายงาน')

@section('content')
<div class="row gutters-sm">
	<div class="col-12 col-md-8 offset-md-2 mb-3 bg-light p-2 rounded">
		<div class="portlet">
			<div class="portlet-body">
				<form method="GET">
					<div class="row">
						<div class="col-12 col-md-4 form-group">

							<select class="form-control" name="type">
								@foreach($reportTypes as $key=>$type)
                                    <option value="{{ $key }}">{{ $type}}</option>
                                @endforeach
							</select>
						</div>
						<div class="col-12 col-md-3 form-group">
							<input typ="date" name="startdate" class="form-control" />
						</div>
						<div class="col-12 col-md-3 form-group">
							<input typ="text" name="enddate" class="form-control" />
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
<?php if(isset($results)){ ?>
<div class="row gutters-sm">
	<div class="col-12">
		<div class="portlet">
			<div class="portlet-body">

			</div>
		</div>
	</div>
</div>
<?php } ?>
@endsection