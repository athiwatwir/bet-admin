@extends('layouts.core')

@section('title', 'รายงานเกม')

@section('content')
<div class="row gutters-sm">
	<div class="col-12">
		<div class="portlet">
			<div class="portlet-header border-bottom">
                <h5>รายงานเกม {{ $game }}</h5>
			</div>
			<!-- /portlet : header -->
			<div class="portlet-body pt-2 px-5">
                <x-game-report-player gamecode="{{ $gamecode }}" />
			</div>
		</div>
	</div>
</div>


<style>
	a.dt-button.dropdown-item.buttons-pdf.buttons-html5 {
		display: none;
	}
    button.btn.btn-secondary.buttons-collection.dropdown-toggle.buttons-colvis.btn-sm.btn-light {
        display: none;
    }
</style>
@endsection