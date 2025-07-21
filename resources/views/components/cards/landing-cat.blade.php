@props([
    'cat' => $cat,
])

<div class="card">
    <img class="w-full h-56 object-cover" src="{{ $cat->primaryPhoto->path }}" alt="{{ $cat->title }}">
    <div class="card-body">
        <div class="flex justify-between items-center">
            <h3 class="text-2xl font-bold text-neutral-900">{{ $cat->title }}</h3>
            <span class="badge badge-secondary">{{ $cat->age }} years old</span>
        </div>
        <p class="mt-2 text-neutral-600">
            {{ Str::limit($cat->description, 120, '...') }}
        </p>
    </div>
    <div class="card-footer text-right">
        <a href="{{ route('cats.show', $cat) }}" class="btn btn-outline">Meet {{ $cat->title }}</a>
    </div>
</div>
