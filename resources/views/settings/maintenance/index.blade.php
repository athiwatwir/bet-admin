@extends('layouts.core')

@section('title', 'ตั้งค่าปรับปรุงระบบ')

@section('content')
<div class="row gutters-sm">

    <div class="col-12 col-lg-12 col-xl-12">

        <div class="portlet">

            <div class="portlet-body pt-4">
                <div class="row">
                    <div class="col-md-9">
                        <div class="set-d-flex mb-3" id="mainten-btn">
                            <div class="text-right">
                                <button id="game-mainten-btn" class="btn btn-vv-sm btn-primary">+ เพิ่มการปิดปรับปรุงเกม</button>
                            </div>
                            <div class="text-right ml-3">
                                <button id="transaction-mainten-btn" class="btn btn-vv-sm btn-primary">+ เพิ่มการปิดปรับปรุงการฝาก-ถอน</button>
                            </div>
                            <div class="text-right ml-3">
                                <button id="website-mainten-btn" class="btn btn-vv-sm btn-primary">+ เพิ่มการปิดปรับปรุงเว็บไซต์</button>
                            </div>
                        </div>
                        <div class="set-d-flex mb-3" id="mainten-save-btn">
                            <button id="mainten-cancel-btn" class="btn btn-vv-sm btn-secondary" style="display: none;">X ยกเลิก</button>
                        </div>
                    </div>
                    <!-- <div class="col-md-3 text-right">
                        <button id="mainten-histories-btn" class="btn btn-vv-sm btn-secondary">รายการปิดปรับปรุงที่ผ่านมา</button>
                    </div> -->
                    <div class="col-12" id="mainten-list">
                        <div class="mainten-title">
                            <h4>รายการตั้งค่า</h4>
                        </div>
                        <section>
                            @include('settings.maintenance.list')
                        </section>
                    </div>
                    <div class="col-12" id="mainten-game-add" style="display: none;">
                        <div class="mainten-title">
                            <h4>เพิ่มการปิดปรับปรุงเกม</h4>
                        </div>
                        <section>
                            @include('settings.maintenance.games.create')
                        </section>
                    </div>
                    <div class="col-12" id="mainten-transaction-add" style="display: none;">
                        <div class="mainten-title">
                            <h4>เพิ่มการปิดปรับปรุงการฝาก-ถอน</h4>
                        </div>
                        <section>
                            @include('settings.maintenance.transaction.create')
                        </section>
                    </div>
                    <div class="col-12" id="mainten-website-add" style="display: none;">
                        <div class="mainten-title">
                            <h4>เพิ่มการปิดปรับปรุงเว็บไซต์</h4>
                        </div>
                        <section>
                            @include('settings.maintenance.website.create')
                        </section>
                    </div>
                    <div class="col-md-12" id="mainten-histories" style="display: none;">
                        <div class="mainten-title">
                            <h4>รายการปิดปรับปรุงเว็บไซต์ที่ผ่านมา...</h4>
                        </div>
                        <section>
                            Hello world...
                        </section>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>


<script>
    const index = document.querySelector('#mainten-list')
    const mainten_game = document.querySelector('#mainten-game-add')
    const mainten_transaction = document.querySelector('#mainten-transaction-add')
    const mainten_website = document.querySelector('#mainten-website-add')
    const mainten_histories = document.querySelector('#mainten-histories')

    const add = document.querySelector('#mainten-btn')
    const cancel = document.querySelector('#mainten-cancel-btn')

    document.querySelector('#game-mainten-btn').addEventListener('click', () => {
        this.setIdStyle(index, mainten_game)
        this.setIdStyle(add, cancel)
    })
    document.querySelector('#transaction-mainten-btn').addEventListener('click', () => {
        this.setIdStyle(index, mainten_transaction)
        this.setIdStyle(add, cancel)
    })

    document.querySelector('#website-mainten-btn').addEventListener('click', () => {
        this.setIdStyle(index, mainten_website)
        this.setIdStyle(add, cancel)
    })

    document.querySelector('#mainten-histories-btn').addEventListener('click', () => {

    })

    cancel.addEventListener('click', () => {
        this.setIdStyle(mainten_game, index)
        this.setIdStyle(mainten_transaction, index)
        this.setIdStyle(mainten_website, index)
        this.setDisplayFlex(cancel, add)
    })

    function setIdStyle(id_1, id_2) {
        id_1.style.display = 'none'
        id_2.style.display = 'initial'
    }

    function setDisplayFlex(id_1, id_2) {
        id_1.style.display = 'none'
        id_2.style.display = 'flex'
    }
</script>
@endsection


<style>
    .col-sm-12.col-md-6.d-flex.align-items-center.justify-content-start,
    .col-sm-12.col-md-6.d-flex.align-items-center.justify-content-end {
        display: none !important;
    }
    .set-d-flex {
        display: flex;
    }
    .mainten-now-check {
        width: 100%;
        height: 20px;
        margin-bottom: 5px;
        margin-top: 5px;
    }
    label.mainten-now-label {
        margin-bottom: 0;
        font-size: 14px;
    }
</style>