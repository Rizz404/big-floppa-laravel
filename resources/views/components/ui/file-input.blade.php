@props([
    'name' => null,
    'label' => null,
    'required' => false,
    'accept' => null,
    'multiple' => false,
    'value' => null,
    'helpText' => null,
    'showPreview' => true,
])

@php
    $dotName = str_replace(['[', ']'], ['.', ''], $name);
    $inputId = $name . '_input';
    $fileInputId = 'fileInput_' . $name;
@endphp

@if ($name)
    <div class="space-y-2" x-data="{
        files: null,
        fileName: '',
        fileCount: 0,
        hasFiles: false,
        isHovering: false,
        previewImages: [],
    
        init() {
            this.$watch('files', value => {
                if (value) {
                    this.hasFiles = value.length > 0;
                    this.fileCount = value.length;
    
                    if (value.length === 1) {
                        this.fileName = value[0].name;
                    } else if (value.length > 1) {
                        this.fileName = value.length + ' files selected';
                    } else {
                        this.fileName = '';
                    }
    
                    if (this.hasFiles && {{ $showPreview ? 'true' : 'false' }}) {
                        this.generatePreviews();
                    }
                }
            });
        },
    
        clearFiles() {
            this.files = null;
            this.fileName = '';
            this.hasFiles = false;
            this.fileCount = 0;
            this.previewImages = [];
            document.getElementById('{{ $fileInputId }}').value = '';
        },
    
        generatePreviews() {
            this.previewImages = [];
    
            for (let i = 0; i < this.files.length && i < 5; i++) {
                const file = this.files[i];
    
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previewImages.push({
                            src: e.target.result,
                            name: file.name,
                            type: 'image'
                        });
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Generate icon based on file type
                    let icon = this.getFileIcon(file);
                    this.previewImages.push({
                        name: file.name,
                        type: 'file',
                        icon: icon
                    });
                }
            }
        },
    
        getFileIcon(file) {
            // Determine icon based on file extension
            const ext = file.name.split('.').pop().toLowerCase();
    
            if (['pdf'].includes(ext)) {
                return 'document-text';
            } else if (['doc', 'docx'].includes(ext)) {
                return 'document';
            } else if (['xls', 'xlsx', 'csv'].includes(ext)) {
                return 'table';
            } else if (['zip', 'rar', '7z'].includes(ext)) {
                return 'archive';
            } else if (['mp3', 'wav', 'ogg'].includes(ext)) {
                return 'musical-note';
            } else if (['mp4', 'mov', 'avi', 'webm'].includes(ext)) {
                return 'film';
            } else {
                return 'document-blank';
            }
        }
    }">
        @if ($label)
            <label for="{{ $fileInputId }}" class="block text-sm font-medium text-text-primary">
                {{ $label }}
                @if ($required)
                    <span class="text-primary ml-0.5">*</span>
                @endif
            </label>
        @endif

        <div class="relative">
            <!-- Hidden original file input -->
            <input type="file" id="{{ $fileInputId }}" name="{{ $name }}" class="hidden"
                accept="{{ $accept }}" {{ $multiple ? 'multiple' : '' }} x-ref="fileInput"
                x-on:change="files = $refs.fileInput.files" {{ $attributes }}>

            <!-- Custom file input design -->
            <div class="flex items-center justify-center w-full" x-on:dragover.prevent="isHovering = true"
                x-on:dragleave.prevent="isHovering = false"
                x-on:drop.prevent="isHovering = false; files = $event.dataTransfer.files">
                <label for="{{ $fileInputId }}"
                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer transition duration-300 ease-in-out"
                    :class="{
                        'bg-bg-main border-secondary hover:bg-bg-alt hover:border-secondary-hover':
                            !hasFiles && !isHovering && !
                            {{ $errors->has($dotName) ? 'true' : 'false' }},
                        'bg-bg-alt border-secondary-hover': isHovering &&
                            !{{ $errors->has($dotName) ? 'true' : 'false' }},
                        'bg-bg-main border-primary': {{ $errors->has($dotName) ? 'true' : 'false' }},
                        'bg-bg-element border-accent': hasFiles && !
                            {{ $errors->has($dotName) ? 'true' : 'false' }}
                    }">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <template x-if="!hasFiles">
                            <svg class="w-10 h-10 mb-3"
                                :class="{
                                    'text-secondary': !
                                        {{ $errors->has($dotName) ? 'true' : 'false' }},
                                    'text-primary': {{ $errors->has($dotName) ? 'true' : 'false' }}
                                }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                        </template>
                        <template x-if="hasFiles">
                            <svg class="w-10 h-10 mb-3 text-accent" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </template>
                        <template x-if="!hasFiles">
                            <p class="mb-2 text-sm text-text-primary-soft">
                                <span class="font-semibold">Click to
                                    upload</span> or drag and drop
                            </p>
                        </template>
                        <template x-if="hasFiles">
                            <p class="mb-2 text-sm font-medium text-text-primary" x-text="fileName"></p>
                        </template>
                        <p class="text-xs text-text-muted" x-show="!hasFiles">
                            {{ empty($accept) ? 'Any file format' : 'Accepts: ' . $accept }}
                        </p>
                    </div>
                </label>
            </div>

            <!-- Clear button when files selected -->
            <div x-show="hasFiles" class="absolute top-2 right-2">
                <button type="button" @click.stop="clearFiles()"
                    class="bg-bg-alt text-white rounded-full p-1 hover:bg-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Help text -->
        @if ($helpText)
            <p class="text-xs text-text-muted mt-1">
                {{ $helpText }}</p>
        @endif

        <!-- File previews -->
        <div x-show="hasFiles && {{ $showPreview ? 'true' : 'false' }}"
            class="mt-3 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
            <template x-for="(preview, index) in previewImages" :key="index">
                <div class="relative">
                    <!-- Image preview -->
                    <template x-if="preview.type === 'image'">
                        <div class="border border-secondary rounded-md overflow-hidden aspect-square">
                            <img :src="preview.src" :alt="preview.name" class="w-full h-full object-cover">
                        </div>
                    </template>

                    <!-- Non-image file preview -->
                    <template x-if="preview.type === 'file'">
                        <div
                            class="border border-secondary rounded-md p-2 bg-bg-main flex flex-col items-center justify-center aspect-square">
                            <!-- Document icon -->
                            <template x-if="preview.icon === 'document'">
                                <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </template>

                            <!-- PDF icon -->
                            <template x-if="preview.icon === 'document-text'">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </template>

                            <!-- Table/spreadsheet icon -->
                            <template x-if="preview.icon === 'table'">
                                <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </template>

                            <!-- Archive icon -->
                            <template x-if="preview.icon === 'archive'">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                                    </path>
                                </svg>
                            </template>

                            <!-- Audio icon -->
                            <template x-if="preview.icon === 'musical-note'">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                                    </path>
                                </svg>
                            </template>

                            <!-- Video icon -->
                            <template x-if="preview.icon === 'film'">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </template>

                            <!-- Default file icon -->
                            <template x-if="preview.icon === 'document-blank'">
                                <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </template>

                            <span class="text-xs font-medium text-text-primary-soft mt-1 truncate w-full text-center"
                                x-text="preview.name.length > 10 ? preview.name.substring(0, 8) + '...' : preview.name"></span>
                        </div>
                    </template>
                </div>
            </template>

            <!-- Show "more files" indicator if more than 5 files -->
            <div x-show="fileCount > 5"
                class="border border-secondary border-dashed rounded-md flex items-center justify-center aspect-square bg-bg-main">
                <span class="text-sm font-medium text-text-primary-soft" x-text="`+${fileCount - 5} more`"></span>
            </div>
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
