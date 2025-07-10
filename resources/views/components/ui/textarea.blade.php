@props([
    'name' => null,
    'label' => null,
    'required' => false,
    'rows' => 3,
    'placeholder' => '',
    'value' => null,
])

@if ($name)
    <div class="space-y-2">
        @if ($label)
            <label for="{{ $name }}"
                class="block text-sm font-medium text-slate-800">
                {{ $label }}
                @if ($required)
                    <span class="text-red-500 ml-0.5">*</span>
                @endif
            </label>
        @endif

        <div class="relative">
            <textarea id="{{ $name }}" name="{{ $name }}"
                placeholder="{{ $placeholder }}" rows="{{ $rows }}"
                {{ $attributes->class([
                    'w-full px-3 py-2 border rounded-md shadow-sm transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-opacity-50 resize-y',
                    'border-red-500 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' => $errors->has(
                        $name,
                    ),
                    'border-slate-300 text-slate-900 focus:ring-slate-500 focus:border-slate-500' => !$errors->has(
                        $name,
                    ),
                ]) }}>{{ old($name, $value) }}</textarea>

            @if ($errors->has($name))
                <div class="absolute top-2 right-2 pointer-events-none">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            @endif
        </div>

        @error($name)
            <p class="mt-1 text-sm text-red-600 flex items-center">
                <svg class="h-4 w-4 mr-1 text-red-500" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>
@endif
