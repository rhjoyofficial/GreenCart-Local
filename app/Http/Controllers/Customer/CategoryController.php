<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('frontend.categories.index', [
            'categories' => Category::all(),
        ]);
    }

    public function show(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return view('frontend.categories.show', [
            'category' => $category,
            'products' => $category->products()
                ->where('approval_status', 'approved')
                ->paginate(12),
        ]);
    }
}
