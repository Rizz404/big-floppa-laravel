@props([
    'name' => null,
    'label' => null,
    'options' => null,
    'required' => false,
])

<div class="space-y-2">
    @if ($label)
        <label class="block mb-2 text-sm font-medium text-slate-800">
            {{ $label }}
            @if ($required)
                <span class="text-red-500 ml-0.5">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <select id="{{ $name }}" name="{{ $name }}"
            {{ $attributes->class([
                'px-3 py-2 block w-full rounded-md border border-slate-300 text-slate-700 focus:ring-slate-500 focus:border-slate-500 shadow-sm',
                'border-red-500' => $errors->has($name),
            ]) }}>
            {{ $slot }}
        </select>

        @if ($errors->has($name))
            <div class="absolute pointer-events-none top-2 right-2">
                <svg class="w-4 h-4 text-red-500" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        @endif
    </div>

    @error($name)
        <p class="flex items-center mt-1 text-sm text-red-600">
            <svg class="w-4 h-4 mr-1 text-red-500" fill="currentColor"
                viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>
