<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Wishlist;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Recent orders
        $recentOrders = $user->orders()
            ->with(['items.product'])
            ->latest()
            ->take(5)
            ->get();

        // Order statistics
        $orderStats = [
            'total' => $user->orders()->count(),
            'pending' => $user->orders()->where('status', 'pending')->count(),
            'processing' => $user->orders()->where('status', 'processing')->count(),
            'delivered' => $user->orders()->where('status', 'delivered')->count(),
        ];

        // Wishlist items
        $wishlistItems = $user->defaultWishlist
            ? $user->defaultWishlist->products()->limit(4)->get()
            : collect();

        // Recent activity (could be expanded)
        $recentActivity = [
            'last_order' => $user->orders()->latest()->first(),
            'wishlist_count' => $user->defaultWishlist ? $user->defaultWishlist->products()->count() : 0,
            'cart_items' => $user->cart ? $user->cart->items()->count() : 0,
        ];

        return view('customer.dashboard.index', compact(
            'recentOrders',
            'orderStats',
            'wishlistItems',
            'recentActivity'
        ));
    }

    public function orders()
    {
        $orders = Auth::user()
            ->orders()
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return view('customer.dashboard.orders', compact('orders'));
    }

    public function wishlist()
    {
        $wishlist = Auth::user()->defaultWishlist;

        $items = $wishlist
            ? $wishlist->products()->paginate(12)
            : collect();

        return view('customer.dashboard.wishlist', compact('items'));
    }

    public function addresses()
    {
        $user = Auth::user();
        $addresses = []; // You might have a separate addresses table

        return view('customer.dashboard.addresses', compact('addresses'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('customer.dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:30',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);

        $user->update($request->all());

        return back()->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }

    public function notifications()
    {
        // For future implementation
        $notifications = [];

        return view('customer.dashboard.notifications', compact('notifications'));
    }

    public function settings()
    {
        $user = Auth::user();
        return view('customer.dashboard.settings', compact('user'));
    }
}
