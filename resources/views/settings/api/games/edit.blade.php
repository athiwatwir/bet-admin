@extends('layouts.core')

@section('title', 'ตั้งค่า API : เกม')

@section('content')
<div class="row gutters-sm">

    <div class="col-12 col-lg-12 col-xl-12">

        <div class="portlet">

            <div class="portlet-body pt-4">
                <div class="text-right mb-3">
                    <button id="api-game-edit-cancel-btn" class="btn btn-vv-sm btn-secondary" style="display: none;">< กลับ</button>
                </div>
                <section>
                    <div id="api-game-edit">
                        <h4>Edit Api Game</h4>
                        <p>GAME : {{ $game->name }}</p>
                        <hr/>
                        @foreach($game->api_url as $url)
                            <p>URL : {{ $url->url }}</p>
                        @endforeach
                        <hr/>
                        <div class="card">
                            <div class="card-body">
                                @include('settings.api.games.components.list_edit_config')
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    
    </div>

</div>

<script>
    
</script>
@endsection