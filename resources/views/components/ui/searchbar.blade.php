@props(['name' => 'search', 'placeholder' => 'Search...', 'value' => null])

<div class="relative">
    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-secondary" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>
    <input type="text" name="{{ $name }}" placeholder="{{ $placeholder }}"
        class="w-full rounded-md py-2 pl-10 pr-3 font-body border shadow-sm transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-opacity-50 border-secondary text-text-primary focus:ring-accent-active focus:border-secondary"
        value="{{ $value }}" onkeydown="if(event.key === 'Enter') this.form.submit();">
</div>
