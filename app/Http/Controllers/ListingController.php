<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexListingRequest;
use App\Models\Listing;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexListingRequest $request)
    {
        $filters = $request->validated();

        // Build query
        $query = Listing::query()
            ->with('breed', 'primaryPhoto')
            ->whereIn('status', ['available', 'sold'])
            ->applyFilters($filters);

        // Debug - hapus setelah selesai debugging
        if (config('app.debug')) {
            logger('Filters received:', $filters);
            logger('SQL Query:', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);
        }

        // Paginate results
        $listings = $query->paginate(20)->withQueryString();

        return view('pages.user.cat.index')
            ->with('cats', $listings)
            ->with('filters', $filters);
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        // if (!in_array($listing->status, ['available', 'sold'])) {
        //     abort(404);
        // }
        $listing->load(['seller', 'breed', 'photos']);
        return view('pages.user.cat.show')
            ->with('cat', $listing);
    }
}
