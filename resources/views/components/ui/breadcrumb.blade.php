<div class="mb-4 flex justify-between items-center">
    @if ($showBackButton && $backUrl)
        <a href="{{ $backUrl }}"
            class="text-slate-600 hover:text-slate-800 flex items-center font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1"
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                    clip-rule="evenodd" />
            </svg>
            {{ $backText }}
        </a>
    @endif

    <nav aria-label="Breadcrumb">
        <ol class="flex flex-wrap items-center text-slate-600 text-sm">
            <li class="flex items-center">
                <a href="{{ route('home') }}"
                    class="hover:text-slate-900 transition-colors duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                        fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="ml-1">Beranda</span>
                </a>
            </li>

            @foreach ($items as $index => $item)
                <li class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 mx-2 text-slate-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>

                    @if ($index < count($items) - 1)
                        <a href="{{ $item['url'] }}"
                            class="hover:text-slate-900 transition-colors duration-200">
                            {{ $item['title'] }}
                        </a>
                    @else
                        <span
                            class="font-medium text-slate-800">{{ $item['title'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
</div>
