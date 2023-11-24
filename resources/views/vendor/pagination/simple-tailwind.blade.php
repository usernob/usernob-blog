@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-start gap-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span
                class="relative inline-flex items-center px-4 py-2 text-sm hover:text-white font-medium text-white bg-ancent-hover cursor-default leading-5 rounded-md">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="relative inline-flex items-center px-4 py-2 text-sm hover:text-white font-medium text-white bg-ancent leading-5 rounded-md hover:bg-ancent-hover focus:outline-none focus:ring ring-ancent transition ease-in-out duration-150">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="relative inline-flex items-center px-4 py-2 text-sm hover:text-white font-medium text-white bg-ancent leading-5 rounded-md hover:bg-ancent-hover focus:outline-none focus:ring ring-ancent transition ease-in-out duration-150">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span
                class="relative inline-flex items-center px-4 py-2 text-sm hover:text-white font-medium text-white bg-ancent-hover cursor-default leading-5 rounded-md">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif
