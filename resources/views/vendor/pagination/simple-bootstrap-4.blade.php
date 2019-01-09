@if ($paginator->hasPages())
    
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            
                <span class="text-grey">@lang('pagination.previous')</span>
            
        @else
            <span>
                <a class="no-underline text-blue" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
            </span>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <span>
                <a class="no-underline text-blue" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
            </span>
        @else
            
                <span class="text-grey">@lang('pagination.next')</span>
            
        @endif
    
@endif
