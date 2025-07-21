@props(['name', 'label' => null, 'required' => false, 'placeholder' => '', 'value' => null, 'rows' => 4])

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

    <textarea id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}" rows="{{ $rows }}"
        @if ($required) required @endif
        {{ $attributes->class(['form-input', 'form-input-error' => $hasError]) }}>{{ old($dotName, $value) }}</textarea>

    @error($dotName)
        <p class="form-error">{{ $message }}</p>
    @enderror
</div>
