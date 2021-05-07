<!-- navigation -->
<div class="col-12 col-lg-3 col-xl-2">

    <nav class="nav-deep nav-deep-light mb-2">

        <h4>Game Groups</h4>

        <!-- mobile only -->
        <button class="clearfix btn btn-toggle btn-sm btn-block text-align-left shadow-md border rounded mb-1 d-block d-lg-none" data-target="#nav_responsive" data-toggle-container-class="d-none d-sm-block bg-white shadow-md border animate-fadein rounded p-3">
            <span class="group-icon px-2 py-2 float-start">
                <i class="fi fi-bars-2"></i>
                <i class="fi fi-close"></i>
            </span>

            <span class="h5 py-2 m-0 float-start font-weight-light">
                Inbox
            </span>
        </button>


        <!-- navigation -->
        <ul id="nav_responsive" class="nav flex-column d-none d-lg-block">

            <li class="nav-item">
                <a class="nav-link px-0" href="{{ url('/games/groups') }}">
                    <i class="fi fi-arrow-end m-0 fs--12"></i> 
                    <span class="px-2 d-inline-block">
                        All Groups
                    </span>
                </a>
            </li>

            @foreach($groups as $group)
                <li class="nav-item @if($group_id == $group->id) active @endif">
                    <a class="nav-link px-0" href="/games/groups/{{ $group->name }}/{{ $group->id }}/game-list">
                        <i class="fi fi-arrow-end m-0 fs--12"></i> 
                        <span class="px-2 d-inline-block">
                            {{ $group->name }}
                        </span>
                    </a>
                </li>
            @endforeach

        </ul>

    </nav>

</div>
<!-- /navigation -->