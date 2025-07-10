@props(['type' => 'info', 'message' => null])

@php
    $isRaw = $type === 'raw';

    $colors = [
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-400',
            'text' => 'text-red-700',
            'icon' => 'text-red-400',
        ],
        'success' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-400',
            'text' => 'text-green-700',
            'icon' => 'text-green-400',
        ],
        'warning' => [
            'bg' => 'bg-yellow-50',
            'border' => 'border-yellow-400',
            'text' => 'text-yellow-700',
            'icon' => 'text-yellow-400',
        ],
        'info' => [
            'bg' => 'bg-blue-50',
            'border' => 'border-blue-400',
            'text' => 'text-blue-700',
            'icon' => 'text-blue-400',
        ],
        'raw' => [
            'bg' => 'bg-slate-100',
            'border' => 'border-slate-500',
            'text' => 'text-slate-800',
            'icon' => 'text-slate-500',
        ],
    ][$type];

    $layoutClasses = $isRaw
        ? 'w-full rounded-md shadow-md'
        : 'fixed top-24 right-0 z-50 max-w-md rounded-r-md shadow-lg';

@endphp

<div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform -translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="{{ $colors['bg'] }} border-l-4 {{ $colors['border'] }} p-4 mb-4 {{ $layoutClasses }}" role="alert"
    @if (!$isRaw) x-init="setTimeout(() => show = false, 5000)" @endif>
    <div class="flex">
        <div class="flex-shrink-0">
            @if ($type === 'error')
                <svg class="h-5 w-5 {{ $colors['icon'] }}" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                        clip-rule="evenodd" />
                </svg>
            @elseif($type === 'success')
                <svg class="h-5 w-5 {{ $colors['icon'] }}" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                        clip-rule="evenodd" />
                </svg>
            @elseif($type === 'warning')
                <svg class="h-5 w-5 {{ $colors['icon'] }}" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                        clip-rule="evenodd" />
                </svg>
            @elseif($isRaw)
                <svg class="h-5 w-5 {{ $colors['icon'] }}" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 12" />
                </svg>
            @else
                <svg class="h-5 w-5 {{ $colors['icon'] }}" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                        clip-rule="evenodd" />
                </svg>
            @endif
        </div>

        <div class="ml-3 flex-1 overflow-hidden @if ($isRaw) max-h-96 overflow-y-auto @endif">
            @if ($isRaw)
                <pre class="text-sm {{ $colors['text'] }} whitespace-pre-wrap break-all font-mono"><code>{{ $message ?? $slot }}</code></pre>
            @else
                <p class="text-sm {{ $colors['text'] }}">
                    {{ $message ?? $slot }}
                </p>
            @endif
        </div>

        <div class="ml-auto pl-3">
            <div class="-mx-1.5 -my-1.5">
                <button @click="show = false" type="button"
                    class="inline-flex rounded-md {{ $colors['bg'] }} p-1.5 {{ $colors['text'] }} hover:{{ str_replace('50', '100', $colors['bg']) }} focus:outline-none focus:ring-2 focus:ring-offset-2 {{ str_replace('400', '500', 'focus:ring-' . $colors['border']) }} cursor-pointer">
                    <span class="sr-only">Dismiss</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
