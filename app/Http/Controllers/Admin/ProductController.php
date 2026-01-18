<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['seller', 'category']);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('sku', 'like', "%$search%")
                    ->orWhereHas('seller', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        // Filter by approval status
        if ($request->has('approval_status') && $request->approval_status !== 'all') {
            $query->where('approval_status', $request->approval_status);
        }

        // Filter by seller
        if ($request->has('seller_id')) {
            $query->where('seller_id', $request->seller_id);
        }

        $products = $query->latest()->paginate(20);
        $sellers = User::whereHas('role', fn($q) => $q->where('slug', 'seller'))->get();

        return view('admin.products.index', compact('products', 'sellers'));
    }

    public function show(Product $product)
    {
        $product->load(['seller', 'category', 'orderItems']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $sellers = User::whereHas('role', fn($q) => $q->where('slug', 'seller'))->get();

        return view('admin.products.edit', compact('product', 'categories', 'sellers'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'seller_id' => 'required|exists:users,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'approval_status' => 'required|in:pending,approved,rejected',
            'is_active' => 'boolean',
        ]);

        $product->update($request->all());

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->orderItems()->exists() || $product->cartItems()->exists()) {
            return back()->with('error', 'Cannot delete product with existing orders or cart items.');
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function approve(Product $product)
    {
        $product->update(['approval_status' => 'approved']);

        return back()->with('success', 'Product approved successfully.');
    }

    public function reject(Product $product)
    {
        $product->update(['approval_status' => 'rejected']);

        return back()->with('success', 'Product rejected.');
    }

    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $product->is_active,
        ]);
    }
}
