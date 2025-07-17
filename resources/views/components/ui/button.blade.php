@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'loading' => false,
    'href' => null,
])

@php
    $tag = $href ? 'a' : 'button';

    $variantClass = match ($variant) {
        'secondary' => 'btn-secondary',
        'outline' => 'btn-outline',
        'success' => 'btn-success',
        'warning' => 'btn-warning',
        'danger' => 'btn-danger',
        'ghost' => 'btn-ghost',
        default => 'btn-primary',
    };

    $sizeClass = match ($size) {
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        default => '',
    };
@endphp

<{{ $tag }} @if ($tag === 'button') type="{{ $type }}" @endif
    @if ($href) href="{{ $href }}" @endif
    {{ $attributes->class(['btn', $variantClass, $sizeClass])->merge(['disabled' => $loading]) }}>
    @if ($loading)
        <span class="loading-spinner mr-2"></span>
    @endif

    {{ $slot }}
    </{{ $tag }}>
