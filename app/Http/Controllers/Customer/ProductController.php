<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('frontend.products.index', [
            'products' => Product::where('approval_status', 'approved')
                ->where('is_active', true)
                ->paginate(12),
        ]);
    }

    public function show(string $slug): View
    {
        $product = Product::where('slug', $slug)
            ->where('approval_status', 'approved')
            ->firstOrFail();

        return view('frontend.products.show', compact('product'));
    }
}
