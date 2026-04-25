<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $bestSellers = Product::where('is_best_seller', true)->take(3)->get();
        $siteReviews = Review::siteReviews()->latest()->take(6)->get();
        return view('Home.index', compact('bestSellers', 'siteReviews'));
    }
}
