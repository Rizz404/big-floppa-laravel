@props([
    'show' => false,
    'position' => 'center', // center | top | right | bottom | left
    'persistent' => false,
    'maxWidth' => '2xl', // sm | md | lg | xl | 2xl | full
    'blur' => false,
    'title' => null,
])

<div x-data="{ showModal: @js($show) }" x-on:keydown.escape.window="if (!@js($persistent)) showModal = false"
    {{ $attributes->whereDoesntStartWith('class') }}>

    <!-- Backdrop -->
    <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-secondary/60 @if ($blur) backdrop-blur-sm @endif"
        @if (!$persistent) @click="showModal = false" @endif style="z-index: 9998;">
    </div>

    <!-- Modal Container -->
    <div x-show="showModal" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="fixed overflow-hidden transform transition-all"
        :class="{
            'w-full max-w-{{ $maxWidth }}': true,
            'left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2': '{{ $position }}'
            === 'center',
            'top-0 left-1/2 -translate-x-1/2 mt-8': '{{ $position }}'
            === 'top',
            'right-0 top-0 h-full': '{{ $position }}'
            === 'right',
            'bottom-0 left-0 w-full': '{{ $position }}'
            === 'bottom',
            'left-0 top-0 h-full': '{{ $position }}'
            === 'left'
        }"
        style="z-index: 9999;">

        <!-- Modal Content -->
        <div class="bg-bg-main rounded-lg shadow-xl h-full flex flex-col">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-secondary flex items-center justify-between">
                <h3 class="text-lg font-sans font-bold text-text-primary">
                    {{ $title }}
                </h3>

                @if (!$persistent)
                    <button @click="showModal = false" class="text-secondary hover:text-text-primary transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif
            </div>

            <!-- Body -->
            <div class="p-6 flex-1 overflow-y-auto">
                {{ $slot }}
            </div>

            <!-- Footer -->
            @isset($footer)
                <div class="px-6 py-4 border-t border-secondary flex justify-end space-x-3">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
