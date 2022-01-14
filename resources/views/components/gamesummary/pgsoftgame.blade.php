<div class="row">
    <div class="col-md-12 border-bottom">
        <p class="float-end d-block fs--12">
            จำนวนการเล่นทั้งหมด : <strong class="text-dark">{{ number_format($reports['hands']) }}</strong> ครั้ง | 
            จำนวนเงินเดิมพันทั้งหมด : <strong class="text-primary">{{ number_format($reports['betAmount'], 2) }}</strong> ฿ | 
            <span class="text-success">ชนะ </span>/<span class="text-danger"> แพ้ </span> ทั้งหมด : <strong class="@if($reports['winLossAmount'] > 0) text-success @elseif($reports['winLossAmount'] < 0) text-danger @endif">{{ number_format($reports['winLossAmount'], 2) }}</strong> ฿
        </p>
    </div>
    <div class="col-md-12 pt-3">
        <x-game-report userid="{{ $userid }}" gamecode="{{ $gamecode }}" items="10" />
    </div>
</div>