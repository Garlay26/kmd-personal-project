@if ($paginator->lastPage() > 1)
<div class="row">
    <div class="col-lg-12">
        <ul class="pagination pagination-rounded justify-content-center mt-3 mb-4 pb-1">
            <li class="page-item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                <a href="{{ $paginator->url(1) }}" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
            </li>
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a href="{{ $paginator->url($i) }}" class="page-link">{{$i}}</a>
                </li>
            @endfor
            <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                <a href="{{ $paginator->url($paginator->currentPage()+1) }}" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
            </li>
        </ul>
    </div>
</div>
@endif