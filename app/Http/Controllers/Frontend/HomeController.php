<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('frontend.home', [
            'featuredProducts' => Product::where('approval_status', 'approved')
                ->where('is_active', true)
                ->latest()
                ->limit(8)
                ->get(),
        ]);
    }

    public function about(): View
    {
        return view('frontend.about');
    }
}
