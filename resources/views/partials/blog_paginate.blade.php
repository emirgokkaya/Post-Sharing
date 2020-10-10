<div class="post-pagination d-flex justify-content-center">
<!-- pagination -->
@if ($paginator->hasPages())
    {{-- Previous Page Link --}}
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

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"><i class="fa fa-angle-right"></i></a>
    @else


    @endif
@endif
</div>






