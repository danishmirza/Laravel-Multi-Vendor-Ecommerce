@if ($paginator->hasPages())
    <div class="col-12 text-right mt-1">
        <div class="pagination-ctm d-inline-block">
            <ul class="my-pagination d-inline-block">
                @if ($paginator->onFirstPage())
                <li class="item active disabled">
                    <a class="page-arow-l">
                        <i class="fas fa-angle-left"></i>
                    </a>
                </li>
                @else
                    <li class="item ">
                        <a href="{{ $paginator->previousPageUrl() }}" class="page-arow-l">
                            <i class="fas fa-angle-left"></i>
                        </a>
                    </li>
                @endif
                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="item">
                            <a href="#" class="link">........</a>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="item active" aria-current="page"><span class="link">{{ $page }}</span></li>
                            @else
                                <li class="item"><a class="link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                <li class="item ">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-arow-l">
                        <i class="fas fa-angle-right"></i>
                    </a>
                </li>
                @else
                        <li class="item active disabled">
                            <a  class="page-arow-l">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                @endif
            </ul>
        </div>
    </div>
@endif
