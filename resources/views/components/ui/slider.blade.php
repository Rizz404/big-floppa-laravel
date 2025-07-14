@props([
    'name',
    'label',
    'id' => $name,
    'min' => 1,
    'max' => 10,
    'step' => 1,
    'value' => 5, // Default value in the middle
])

<div x-data="{ value: {{ $value }}, min: {{ $min }}, max: {{ $max }} }" class="space-y-3">
    <div class="flex justify-between items-center">
        <label for="{{ $id }}" class="form-label mb-0">{{ $label }}</label>
        <div class="bg-primary-100 text-primary-600 text-sm font-bold px-3 py-1 rounded-full">
            {{-- Input hidden untuk mengirim nilai ke backend --}}
            <input type="hidden" name="{{ $name }}" :value="value">
            <span x-text="value"></span> / {{ $max }}
        </div>
    </div>
    <input id="{{ $id }}" type="range" min="{{ $min }}" max="{{ $max }}"
        step="{{ $step }}" x-model.number="value" class="w-full"
        x-effect="$el.style.backgroundSize = `${((value - min) / (max - min)) * 100}% 100%`">
</div>
