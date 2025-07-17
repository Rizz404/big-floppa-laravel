@props(['name', 'label' => null, 'required' => false])

@php
    $dotName = str_replace(['[', ']'], ['.', ''], $name);
    $hasError = $errors->has($dotName);
@endphp

<div class="form-group">
    @if ($label)
        <label for="{{ $name }}" @class(['form-label', 'form-label-required' => $required])>
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        <select id="{{ $name }}" name="{{ $name }}"
            {{ $attributes->class(['form-select', 'form-input-error' => $hasError]) }}
            @if ($required) required @endif>
            {{ $slot }}
        </select>
    </div>

    @error($dotName)
        <p class="form-error">{{ $message }}</p>
    @enderror
</div>
