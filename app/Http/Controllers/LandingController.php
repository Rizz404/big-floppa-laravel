<?php

namespace App\Http\Controllers;

use App\Models\Breed;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // * Jangan lupa get
        $breeds = Breed::query()->limit(4)->get();

        return view("pages.landing.index")
            ->with('breeds', $breeds);
    }
}
