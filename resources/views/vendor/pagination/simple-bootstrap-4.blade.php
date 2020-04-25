@if ($paginator->hasPages())
    <div class="paginator-navigation">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page disabled" aria-disabled="true">
                    <span class="page">@lang('pagination.previous')</span>
                </li>
            @else
                <li class="page">
                    <a class="page" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page">
                    <a class="page" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                </li>
            @else
                <li class="page disabled" aria-disabled="true">
                    <span class="page">@lang('pagination.next')</span>
                </li>
            @endif
        </ul>
    </div>
@endif
