<nav aria-label="pagination">
    <ul class="pagination pagination-pill justify-content-end justify-content-center justify-content-md-end">

        <li class="{{ $data->onFirstPage() ? 'page-item btn-pill disabled' : 'page-item btn-pill' }}">
            <a class="page-link" href="{{ $data->previousPageUrl() }}" tabindex="-1" aria-disabled="true">ก่อนหน้า</a>
        </li>
        
        <li class="page-item active" aria-current="page">
            {{ $data->links() }}
        </li>
        
        <li class="{{ $data->currentPage() == $data->lastPage() ? 'page-item disabled' : 'page-item' }}">
            <a class="page-link" href="{{ $data->nextPageUrl() }}">ถัดไป</a>
        </li>

    </ul>

    <div class="justify-content-end justify-content-center justify-content-md-end text-right">
        <small>หน้า : {{ $data->currentPage() }} / {{ $data->lastPage() }}</small>
    </div>
</nav>