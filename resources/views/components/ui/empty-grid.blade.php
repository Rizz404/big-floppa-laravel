@props([
    'title' => 'Belum ada data',
    'description' => 'Mohon maaf, data belum tersedia.',
])

<div class="col-span-full bg-white rounded-lg p-8 text-center shadow border border-bg-main">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-primary opacity-70" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
    </svg>
    <h3 class="mt-4 text-lg font-medium text-text-primary font-sans">
        {{ $title }}
    </h3>
    <p class="mt-2 text-text-primary opacity-80 font-body">
        {{ $description }}
    </p>
</div>
