@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center">
            <!-- Previous Button -->
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">&larr;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&larr;</a>
                </li>
            @endif

            <!-- Pagination Links -->
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <!-- Next Button -->
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&rarr;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">&rarr;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
