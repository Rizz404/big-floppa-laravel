@props([
    'name' => null,
    'label' => null,
    'required' => false,
    'value' => null,
])

@if ($name)
    <div x-data="{}" x-init="tinymce.init({
        target: $refs.tinymce, // Use x-ref to target the specific textarea
        plugins: 'code table lists image media link',
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | link image media',
        height: 400,
        setup: function(editor) {
            // This ensures the underlying textarea is updated when the editor content changes,
            // so the form submission sends the correct data.
            editor.on('change', function() {
                editor.save();
            });
            editor.on('keyup', function() {
                editor.save();
            });
        }
    });" class="space-y-2">
        @if ($label)
            <label for="{{ $name }}" class="block text-sm font-medium text-slate-800">
                {{ $label }}
                @if ($required)
                    <span class="text-red-500 ml-0.5">*</span>
                @endif
            </label>
        @endif

        <div>
            <textarea x-ref="tinymce" id="{{ $name }}" name="{{ $name }}"
                {{ $attributes->merge(['class' => 'hidden']) }}>{!! old($name, $value) !!}</textarea>
        </div>

        @error($name)
            <p class="mt-1 text-sm text-red-600 flex items-center">
                <svg class="h-4 w-4 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>
@endif
