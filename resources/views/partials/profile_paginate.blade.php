@if($paginator->hasPages())
    <nav aria-label="Page navigation example">
    <ul class="pagination">
            @if(!$paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            @endif

            @if($paginator->currentPage() > 3)
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
            @endif

            @if($paginator->currentPage() > 4)
                <li class="page-item"><a href="javascript:void(0)" class="page-link">...</a></li>
            @endif

            @foreach(range(1, $paginator->lastPage()) as $i)
                @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                    @if ($i == $paginator->currentPage())
                            <li class="page-item"><a href="javascript:void(0)" class="page-link text-secondary">{{ $i }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
            @endforeach


            @if($paginator->currentPage() < $paginator->lastPage() - 3)
                <span>...</span>
            @endif
            @if($paginator->currentPage() < $paginator->lastPage() - 2)
                <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            @endif
    </ul>
</nav>
@endif



{{--@if ($paginator->hasPages())
    --}}{{-- Previous Page Link --}}{{--
    @if ($paginator->onFirstPage())


    @else
        <a href="{{$paginator->previousPageUrl()}}" ><i class="fa fa-angle-left"></i></a>
    @endif

    @if($paginator->currentPage() > 3)
        <a href="{{ $paginator->url(1) }}">1</a>
    @endif
    @if($paginator->currentPage() > 4)
        <span>...</span>
    @endif


    @foreach(range(1, $paginator->lastPage()) as $i)
        @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
            @if ($i == $paginator->currentPage())
                <span class="current">{{ $i }}</span>
            @else
                <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
            @endif
        @endif
    @endforeach

    @if($paginator->currentPage() < $paginator->lastPage() - 3)
        <span>...</span>
    @endif
    @if($paginator->currentPage() < $paginator->lastPage() - 2)
        <a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
    @endif

    --}}{{-- Next Page Link --}}{{--
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"><i class="fa fa-angle-right"></i></a>
    @else


    @endif
@endif--}}
