@props([
    'cat' => $cat,
])

<div class="card">
    <img class="w-full h-56 object-cover" src="{{ $cat->primaryPhoto->path }}" alt="{{ $cat->name }}">
    <div class="card-body">
        <div class="flex justify-between items-center">
            <h3 class="text-2xl font-bold text-neutral-900">{{ $cat->name }}</h3>
            <span class="badge badge-secondary">{{ $cat->age }} years old</span>
        </div>
        <p class="mt-2 text-neutral-600">{{ $cat->description }}</p>
    </div>
    <div class="card-footer text-right">
        <a href="#" class="btn btn-outline">Meet {{ $cat->name }}</a>
    </div>
</div>
