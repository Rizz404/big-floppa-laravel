@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{!! __('Pagination Navigation') !!}" class="flex items-center justify-between py-6">
        {{-- Results info --}}
        <div class="flex items-center gap-3">
            <div
                class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <div class="text-sm text-neutral-500">Page {{ $paginator->currentPage() }} from
                    {{ $paginator->lastPage() }}</div>
                <div class="text-xs text-neutral-400">
                    @if ($paginator->firstItem())
                        {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} from {{ $paginator->total() }} result
                    @else
                        {{ $paginator->count() }} result
                    @endif
                </div>
            </div>
        </div>

        {{-- Navigation buttons --}}
        <div class="flex items-center gap-2">
            {{-- Previous button --}}
            @if ($paginator->onFirstPage())
                <span
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-neutral-400 bg-neutral-100 border border-neutral-200 cursor-not-allowed rounded-xl leading-5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="hidden sm:block">{!! __('pagination.previous') !!}</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-xl leading-5 hover:bg-gradient-to-br hover:from-neutral-50 hover:to-neutral-100 hover:border-neutral-300 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 active:bg-neutral-100 transition-all duration-200 shadow-sm group">
                    <svg class="w-4 h-4 group-hover:scale-110 group-hover:-translate-x-0.5 transition-all duration-200"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="hidden sm:block">{!! __('pagination.previous') !!}</span>
                </a>
            @endif

            {{-- Page indicator --}}
            <div class="hidden sm:flex items-center gap-1 px-3 py-2 bg-primary-50 border border-primary-200 rounded-lg">
                @for ($i = max(1, $paginator->currentPage() - 1); $i <= min($paginator->lastPage(), $paginator->currentPage() + 1); $i++)
                    @if ($i == $paginator->currentPage())
                        <span
                            class="inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-white bg-primary-500 rounded-full shadow-lg ring-2 ring-primary-200">
                            {{ $i }}
                        </span>
                    @else
                        <a href="{{ $paginator->url($i) }}"
                            class="inline-flex items-center justify-center w-8 h-8 text-xs font-medium text-primary-600 hover:bg-primary-100 rounded-full transition-all duration-200 hover:scale-110">
                            {{ $i }}
                        </a>
                    @endif
                @endfor

                @if ($paginator->currentPage() + 1 < $paginator->lastPage())
                    <span class="text-primary-400 px-1">...</span>
                    <a href="{{ $paginator->url($paginator->lastPage()) }}"
                        class="inline-flex items-center justify-center w-8 h-8 text-xs font-medium text-primary-600 hover:bg-primary-100 rounded-full transition-all duration-200 hover:scale-110">
                        {{ $paginator->lastPage() }}
                    </a>
                @endif
            </div>

            {{-- Next button --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-br from-primary-500 to-primary-600 border border-primary-500 rounded-xl leading-5 hover:from-primary-600 hover:to-primary-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 active:from-primary-700 active:to-primary-800 transition-all duration-200 shadow-md group hover:scale-105">
                    <span class="hidden sm:block">{!! __('pagination.next') !!}</span>
                    <svg class="w-4 h-4 group-hover:scale-110 group-hover:translate-x-0.5 transition-all duration-200"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            @else
                <span
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-neutral-400 bg-neutral-100 border border-neutral-200 cursor-not-allowed rounded-xl leading-5 transition-all duration-200">
                    <span class="hidden sm:block">{!! __('pagination.next') !!}</span>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif
