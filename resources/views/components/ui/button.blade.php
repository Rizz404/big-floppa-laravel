@props(['type' => 'submit'])

<button type="{{ $type }}"
    {{ $attributes->merge(['class' => 'px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition-colors cursor-pointer']) }}>
    {{ $slot }}
</button>
