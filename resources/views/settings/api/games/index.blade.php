@extends('layouts.core')

@section('title', 'รายการเกม')

@section('content')
<div class="row gutters-sm">

    <div class="col-12 col-lg-12 col-xl-12">

        <div class="portlet">

            <div class="portlet-body pt-4">
                <div class="text-right mb-3">
                    <button id="api-game-create-btn" class="btn btn-vv-sm btn-primary">+ เพิ่มเกม</button>
                    <button id="api-game-create-cancel-btn" class="btn btn-vv-sm btn-secondary" style="display: none;">X ยกเลิก</button>
                </div>
                <section>
                    <div id="api-game-index">
                        @include('settings.api.games.components.list')
                    </div>
                    <div id="api-game-create" style="display: none;">
                        @include('settings.api.games.create')
                    </div>
                </section>
            </div>

        </div>
    
    </div>

</div>

<script>
    let index = document.querySelector('#api-game-index')
    let create = document.querySelector('#api-game-create')
    let create_btn = document.querySelector('#api-game-create-btn')
    let create_cancel_btn = document.querySelector('#api-game-create-cancel-btn')

    create_btn.addEventListener('click', () => {
        this.setIdStyle(index, create)
        this.setIdStyle(create_btn, create_cancel_btn)
    })

    create_cancel_btn.addEventListener('click', () => {
        this.setIdStyle(create, index)
        this.setIdStyle(create_cancel_btn, create_btn)
    })

    function setIdStyle(id_1, id_2) {
        id_1.style.display = 'none'
        id_2.style.display = 'initial'
    }
</script>
@endsection