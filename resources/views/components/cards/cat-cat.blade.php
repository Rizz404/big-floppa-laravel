@props(['cat'])

<div class="card group">
    <a href="{{ route('cats.show', $cat) }}" class="block overflow-hidden">
        <img src="{{ $cat->primaryPhoto?->path ?? 'https://placekitten.com/400/300?image=' . $cat->id }}"
            alt="{{ $cat->title }}"
            class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
    </a>
    <div class="card-body">
        <div class="flex justify-between items-start">
            <h4 class="font-bold text-lg text-neutral-900">
                <a href="{{ route('cats.show', $cat) }}" class="hover:text-primary-600">{{ $cat->title }}</a>
            </h4>
            <span class="badge {{ $cat->status == 'available' ? 'badge-success' : 'badge-danger' }}">
                {{ Str::ucfirst($cat->status) }}
            </span>
        </div>
        <p class="text-sm text-neutral-500">{{ $cat->breed->name }}</p>

        <p class="mt-2 text-lg font-bold text-primary-600">
            Rp {{ number_format($cat->price, 0, ',', '.') }}
        </p>

        <div class="mt-4 flex flex-wrap gap-2">
            @if ($cat->is_vaccinated)
                <span class="badge badge-secondary">Vaccinated</span>
            @endif
            @if ($cat->is_dewormed)
                <span class="badge badge-secondary">Dewormed</span>
            @endif
        </div>
    </div>
</div>
