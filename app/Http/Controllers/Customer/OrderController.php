<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        return view('frontend.orders.index', [
            'orders' => Auth::user()
                ->orders()
                ->latest()
                ->paginate(10),
        ]);
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return view('frontend.orders.show', [
            'order' => $order->load('items.product'),
        ]);
    }
}
