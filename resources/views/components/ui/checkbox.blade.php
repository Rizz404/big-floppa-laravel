@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null, // Untuk grup: array value yg tercentang. Untuk tunggal: value saat tercentang.
    'checked' => false, // Hanya untuk checkbox tunggal: status awal.
    'required' => false,
])

@php
    $dotName = str_replace(['[', ']'], ['.', ''], $name);
    $hasError = $errors->has($dotName);
@endphp

<div class="form-group">
    {{-- Label utama untuk grup checkbox --}}
    @if (!empty($options) && $label)
        <label @class(['form-label', 'form-label-required' => $required])>
            {{ $label }}
        </label>
    @endif

    <div class="{{ !empty($options) ? 'space-y-2' : 'flex items-center' }}">
        @if (!empty($options))
            {{-- Render grup checkbox --}}
            @foreach ($options as $optionValue => $optionLabel)
                <div class="flex items-center">
                    <input type="checkbox" id="{{ $name }}_{{ $optionValue }}" name="{{ $name }}[]"
                        value="{{ $optionValue }}" @checked(in_array($optionValue, (array) old($dotName, $value ?? [])))
                        {{ $attributes->class(['form-checkbox', 'border-danger-500' => $hasError]) }}>
                    <label for="{{ $name }}_{{ $optionValue }}"
                        class="ml-2 text-sm font-medium text-neutral-800">
                        {{ $optionLabel }}
                    </label>
                </div>
            @endforeach
        @else
            {{-- Render checkbox tunggal --}}
            <input type="checkbox" id="{{ $name }}" name="{{ $name }}" value="{{ $value ?? 1 }}"
                @checked(old($dotName, $checked))
                {{ $attributes->class(['form-checkbox', 'border-danger-500' => $hasError]) }}>
            @if ($label)
                <label for="{{ $name }}" @class([
                    'ml-2',
                    'form-label',
                    '!mb-0',
                    'form-label-required' => $required,
                ])>
                    {{ $label }}
                </label>
            @endif
        @endif
    </div>

    @error($dotName)
        <p class="form-error">{{ $message }}</p>
    @enderror
</div>
