<?php

namespace App\Http\Controllers;

use App\Models\Breed;
use App\Http\Requests\StoreBreedRequest;
use App\Http\Requests\UpdateBreedRequest;
use App\Models\Listing;
use Illuminate\Http\Request;

class BreedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all();

        $countries = Breed::query()
            ->whereNotNull('origin_country')
            ->distinct()
            ->pluck('origin_country')
            ->sort()
            ->values();

        $breeds = Breed::query()
            ->withCount(['listings' => function ($query) {
                $query->where('status', 'available');
            }])
            ->applyFilters($filters)
            ->paginate(12)
            ->withQueryString();

        return view('pages.user.breed.index', compact('breeds', 'countries', 'filters'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Breed $breed)
    {
        $filters = $request->all();

        // * Query dasar untuk listing yang tersedia pada ras ini
        $baseQuery = Listing::where('breed_id', $breed->id)->where('status', 'available');

        // * Ambil rentang harga SEBELUM filter harga diterapkan
        $priceRange = (clone $baseQuery)
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        // * Ambil listing dengan semua filter yang diterapkan
        $cats = (clone $baseQuery)
            ->with('primaryPhoto')
            ->applyFilters($filters)
            ->paginate(10) // * Atau sesuaikan jumlah per halaman
            ->withQueryString();

        // * Asumsi path view Anda adalah 'pages.user.breed.show'
        return view('pages.user.breed.show', compact('breed', 'cats', 'filters', 'priceRange'));
    }
}
