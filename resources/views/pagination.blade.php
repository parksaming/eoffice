
@if (isset($paginator) && $paginator->lastPage() > 1)
    <ul class="pagination ml-auto" style="float: left;padding: 0 0 0 15px;">
        <li class="{{ ($paginator->currentPage() == 1) ? ' disabled ' : '' }} page-item">
            <a class=" page-link page-link-not {{ ($paginator->currentPage() == 1) ? ' color-paginator' : '' }}" href="{{ $paginator->url(1) }}" aria-label="Previous">
                <span aria-hidden="true"><i class="ti-angle-left" aria-hidden="true"></i></span>
                <span class="">«</span>
            </a>
        </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }} page-item">
                <a class=" page-link " href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled ' : '' }} page-item">
            <a href="{{ $paginator->url($paginator->currentPage()+1) }}" class="page-link page-link-not {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' color-paginator' : '' }}" aria-label="Next">
                <span aria-hidden="true"><i class="ti-angle-right" aria-hidden="true"></i></span>
                <span class="">»</span>
            </a>
        </li>
    </ul>

@endif
