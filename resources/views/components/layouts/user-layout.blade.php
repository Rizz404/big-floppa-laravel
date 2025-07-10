@props(['title' => ''])


<x-app title="{{ $title }}">
    <x-partials.header />

    <div class="fixed top-0 left-0 z-50 w-full pointer-events-none p-4">
        @php
            $alertTypes = ['success', 'error', 'warning', 'info', 'raw'];
        @endphp

        @foreach ($alertTypes as $type)
            @if (session()->has($type))
                <div class="pointer-events-auto">
                    <x-ui.alert type="{{ $type }}">
                        {{ session($type) }}
                    </x-ui.alert>
                </div>
            @endif
        @endforeach
    </div>

    {{ $slot }}
</x-app>
