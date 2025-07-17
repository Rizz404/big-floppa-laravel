<?php

namespace App\Http\Controllers;

use App\Models\Breed;
use App\Models\Listing;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // * Jangan lupa get
        $breeds = Breed::query()->limit(4)->get();
        $cats = Listing::with('primaryPhoto')->limit(3)->get();

        return view("pages.landing.index")
            ->with('breeds', $breeds)
            ->with('cats', $cats);
    }
}
