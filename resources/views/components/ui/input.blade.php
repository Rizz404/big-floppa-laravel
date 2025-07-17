@props([
    'name',
    'label' => null,
    'type' => 'text',
    'required' => false,
    'placeholder' => '',
    'value' => null,
    'autocomplete' => null,
    'step' => null,
])

@php
    $dotName = str_replace(['[', ']'], ['.', ''], $name);
    $hasError = $errors->has($dotName);
    $isPassword = $type === 'password';
@endphp

<div class="form-group">
    @if ($label)
        <label for="{{ $name }}" @class(['form-label', 'form-label-required' => $required])>
            {{ $label }}
        </label>
    @endif

    <div class="relative" x-data="{ showPassword: false }">
        <input :type="{{ $isPassword ? "showPassword ? 'text' : 'password'" : "'$type'" }}" id="{{ $name }}"
            name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ old($dotName, $value) }}"
            @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if ($step) step="{{ $step }}" @endif
            @if ($required) required @endif
            {{ $attributes->class(['form-input', 'form-input-error' => $hasError, 'pr-10' => $isPassword || $hasError]) }}>

        @if ($isPassword || $hasError)
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 text-base">
                @if ($hasError)
                    <i class="fa-solid fa-circle-exclamation text-danger-500 pointer-events-none"></i>
                @elseif($isPassword)
                    <button type="button" @click="showPassword = !showPassword"
                        class="btn-reset text-neutral-500 hover:text-neutral-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-full"
                        aria-label="Toggle password visibility">
                        <i class="fa-solid fa-eye" x-show="!showPassword"></i>
                        <i class="fa-solid fa-eye-slash" x-show="showPassword" style="display: none;"></i>
                    </button>
                @endif
            </div>
        @endif
    </div>

    @error($dotName)
        <p class="form-error">{{ $message }}</p>
    @enderror
</div>
