@if ($paginator->hasPages())
    <ul class="c-pagenation" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="c-pagenation__li" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="c-pagenation__arrow" aria-hidden="true">&lsaquo;</span>
            </li>
        @else
            <li class="c-pagenation__li">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"  class="c-pagenation__link">&lsaquo;</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="c-pagenation__li" aria-disabled="true"><span class="c-pagenation__arrow">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="c-pagenation__li" aria-current="page"><span class="c-pagenation__span">{{ $page }}</span></li>
                    @else
                        <li class="c-pagenation__li"><a href="{{ $url }}"  class="c-pagenation__link">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="c-pagenation__li">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"  class="c-pagenation__link">&rsaquo;</a>
            </li>
        @else
            <li class="c-pagenation__li" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="c-pagenation__arrow" aria-hidden="true">&rsaquo;</span>
            </li>
        @endif
    </ul>
@endif
