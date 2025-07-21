@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between py-6">
        {{-- Mobile pagination --}}
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-neutral-400 bg-neutral-100 border border-neutral-200 cursor-not-allowed rounded-xl leading-5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-xl leading-5 hover:bg-neutral-50 hover:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 active:bg-neutral-100 transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-xl leading-5 hover:bg-neutral-50 hover:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 active:bg-neutral-100 transition-all duration-200 shadow-sm hover:shadow-md">
                    {!! __('pagination.next') !!}
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            @else
                <span
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-neutral-400 bg-neutral-100 border border-neutral-200 cursor-not-allowed rounded-xl leading-5 transition-all duration-200">
                    {!! __('pagination.next') !!}
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
            @endif
        </div>

        {{-- Desktop pagination --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            {{-- Results info --}}
            <div class="flex items-center gap-2">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-100">
                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="text-sm text-neutral-600">
                    <span class="font-medium text-neutral-900">
                        @if ($paginator->firstItem())
                            {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }}
                        @else
                            {{ $paginator->count() }}
                        @endif
                    </span>
                    from <span class="font-medium text-neutral-900">{{ $paginator->total() }}</span> result
                </div>
            </div>

            {{-- Page numbers --}}
            <div class="flex items-center gap-1">
                {{-- Previous button --}}
                @if ($paginator->onFirstPage())
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 text-neutral-400 bg-neutral-100 border border-neutral-200 cursor-not-allowed rounded-xl transition-all duration-200"
                        aria-disabled="true">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        class="inline-flex items-center justify-center w-10 h-10 text-neutral-600 bg-white border border-neutral-200 rounded-xl hover:bg-neutral-50 hover:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-1 active:bg-neutral-100 transition-all duration-200 shadow-sm hover:shadow-md group"
                        aria-label="{{ __('pagination.previous') }}">
                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform duration-200" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif

                {{-- Page numbers --}}
                @foreach ($elements as $element)
                    {{-- Three dots separator --}}
                    @if (is_string($element))
                        <span class="inline-flex items-center justify-center w-10 h-10 text-neutral-500 cursor-default">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </span>
                    @endif

                    {{-- Array of page links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page"
                                    class="inline-flex items-center justify-center w-10 h-10 text-sm font-semibold text-white bg-primary-500 border border-primary-500 rounded-xl cursor-default shadow-lg ring-2 ring-primary-200 animate-pulse">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-neutral-600 bg-white border border-neutral-200 rounded-xl hover:bg-primary-50 hover:text-primary-600 hover:border-primary-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-1 active:bg-primary-100 transition-all duration-200 shadow-sm hover:shadow-md hover:scale-105"
                                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next button --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                        class="inline-flex items-center justify-center w-10 h-10 text-neutral-600 bg-white border border-neutral-200 rounded-xl hover:bg-neutral-50 hover:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-1 active:bg-neutral-100 transition-all duration-200 shadow-sm hover:shadow-md group"
                        aria-label="{{ __('pagination.next') }}">
                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform duration-200" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                @else
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 text-neutral-400 bg-neutral-100 border border-neutral-200 cursor-not-allowed rounded-xl transition-all duration-200"
                        aria-disabled="true">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                @endif
            </div>

            {{-- Quick jump to pages (optional) --}}
            @if ($paginator->lastPage() > 10)
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-neutral-500">Lompat ke:</span>
                    <div class="relative">
                        <select onchange="window.location.href=this.value"
                            class="appearance-none bg-white border border-neutral-200 rounded-lg px-3 py-1 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 cursor-pointer">
                            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                                <option value="{{ $paginator->url($i) }}"
                                    @if ($i == $paginator->currentPage()) selected @endif>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </nav>
@endif
