@props([
    'name' => null,
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
@endphp

@if ($name)
    <div class="space-y-2" x-data="{ showPassword: false }">
        @if ($label)
            <label for="{{ $name }}" class="block text-sm font-medium text-text-primary">
                {{ $label }}
                @if ($required)
                    <span class="text-primary ml-0.5">*</span>
                @endif
            </label>
        @endif

        <div class="relative">
            <input :type="showPassword ? 'text' : '{{ $type }}'" id="{{ $name }}"
                name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ old($dotName, $value) }}"
                autocomplete="{{ $autocomplete }}" step="{{ $step }}"
                {{ $attributes->class([
                    'w-full px-3 py-2 border rounded-md shadow-sm transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-opacity-50 pr-10',
                    'border-primary text-primary placeholder-bg-main focus:ring-primary focus:border-primary' => $errors->has($dotName),
                    'border-secondary text-text-primary focus:ring-accent-active focus:border-secondary' => !$errors->has($dotName),
                ]) }}>

            @if ($type === 'password')
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <button type="button" @click="showPassword = !showPassword"
                        class="text-secondary hover:text-text-primary transition-colors">
                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M10.586 10.586l4.243 4.243M4 4l3.05 3.05m12.8 1.8L20 16.15M1 1l22 22" />
                        </svg>
                    </button>
                </div>
            @endif

            @if ($errors->has($dotName))
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            @endif
        </div>

        @error($dotName)
            <p class="flex items-center mt-1 text-sm text-primary">
                <svg class="w-4 h-4 mr-1 text-primary" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>
@endif
