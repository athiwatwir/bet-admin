@extends('layouts.core')

@section('title', 'รายละเอียด PG สล๊อต')

@section('content')
<div class="row gutters-sm">
	<div class="col-12 col-md-10 offset-md-1 mb-3 bg-light p-2 rounded">
		<div class="portlet">
			<div class="portlet-body">
                <div class="row gutters-sm">
                    <div class="col-md-4 px-3 pt-2">
                        <h4 class="mb-4">รายละเอียดการเล่นเกม</h4>
                        <div class="border rounded px-2 py-3 mb-3">
                            <p><small>บัญชีผู้ใช้งาน :</small> <strong><a href="/users/{{ $player }}/{{ $player_id }}/view" class="text-dark border-bottom" target="_blank"><i class="fas fa-user-circle"></i> {{ $player }}</a></strong> </p>
                            <p><small>จำนวนการเล่นทั้งหมด :</small> <strong class="text-dark">{{ number_format($hands) }}</strong> <small>ครั้ง</small> </p>
                            <p><small>จำนวนเงินเดิมพันทั้งหมด :</small> <strong class="text-primary">{{ number_format($betAmount, 2) }}</strong> <small>฿</small> </p>
                            <p><small><span class="text-success">ชนะ</span> / <span class="text-danger">แพ้</span> ทั้งหมด :</small> <strong class="@if($winLossAmount > 0) text-success @elseif($winLossAmount < 0) text-danger @endif my-2">{{ number_format($winLossAmount, 2) }}</strong> <small>฿</small> </p>
                        </div>
                        <a href="{{ url('/reports/pgsoft') }}" class="btn btn-vv-sm rounded-circle-xs btn-primary btn-pill js-stoppropag"><small><< ย้อนกลับ</small></a>
                    </div>

                    <div class="col-md-8">
                        <x-game-report userid="{{ $player_id }}" gamecode="PGGAME" items="50" />
                    </div>
                </div>
        
			</div>
		</div>
	</div>
</div>

<style>
	a.dt-button.dropdown-item.buttons-pdf.buttons-html5 {
		display: none;
	}
    .dt-buttons.btn-group.flex-wrap {
        display: none;
    }
</style>
@endsection