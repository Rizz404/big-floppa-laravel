@props([
    'name' => null,
    'label' => null,
    'options' => null,
    'multiple' => false,
    'required' => false,
    'labelPosition' => 'side', // Opsi: 'top', 'side'
    'checked' => false, // Untuk menentukan apakah checkbox dicentang atau tidak
    'value' => null, // Tambahkan parameter value untuk checkbox dalam array
])

<div class="space-y-2">
    @if ($label && $labelPosition === 'top')
        <label class="block text-sm font-medium text-text-primary mb-2">
            {{ $label }}
            @if ($required)
                <span class="text-primary ml-0.5">*</span>
            @endif
        </label>
    @endif

    <div class="{{ $multiple ? 'space-y-2' : 'flex items-center' }}">
        @if ($options)
            @foreach ($options as $optValue => $optionLabel)
                <div class="flex items-center mr-4">
                    <div class="relative flex items-center">
                        <input type="checkbox" id="{{ $name }}{{ $multiple ? '_' . $optValue : '' }}"
                            name="{{ $multiple ? $name . '[]' : $name }}" value="{{ $optValue }}"
                            {{ $attributes->class([
                                'rounded border-secondary text-primary focus:ring-primary focus:border-primary shadow-sm',
                                'border-primary' => $errors->has($name),
                            ]) }}>
                        @if ($errors->has($name))
                            <div class="absolute -top-1 -right-1 pointer-events-none">
                                <svg class="h-4 w-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <label for="{{ $name }}{{ $multiple ? '_' . $optValue : '' }}"
                        class="ml-2 text-sm text-text-primary-soft">
                        {{ $optionLabel }}
                    </label>
                </div>
            @endforeach
        @else
            <div class="relative flex items-center">
                <input type="checkbox" id="{{ $name }}_{{ $value ?? 'default' }}" name="{{ $name }}"
                    value="{{ $value ?? '1' }}" {{ $checked || old($name, $checked) ? 'checked' : '' }}
                    {{ $attributes->class([
                        'rounded border-secondary text-primary focus:ring-primary focus:border-primary shadow-sm',
                        'border-primary' => $errors->has($name),
                    ]) }}>
                @if ($errors->has($name))
                    <div class="absolute -top-1 -right-1 pointer-events-none">
                        <svg class="h-4 w-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                @endif
            </div>
            @if ($label && $labelPosition === 'side')
                <label for="{{ $name }}_{{ $value ?? 'default' }}"
                    class="ml-2 text-sm text-text-primary-soft">
                    {{ $label }}
                    @if ($required)
                        <span class="text-primary ml-0.5">*</span>
                    @endif
                </label>
            @endif
        @endif
    </div>

    @error($name)
        <p class="mt-1 text-sm text-primary flex items-center">
            <svg class="h-4 w-4 mr-1 text-primary" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>
