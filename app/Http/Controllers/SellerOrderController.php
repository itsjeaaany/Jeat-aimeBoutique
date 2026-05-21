<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        abort_unless($user->isSeller(), 403);

        $orders = Order::whereHas('items.product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['items.product', 'user'])
        ->latest()
        ->paginate(12);

        return view('orders.seller-index', compact('orders'));
    }

    public function show(Order $order)
    {
        $user = Auth::user();

        abort_unless($user->isSeller() && $order->items->contains(function ($item) use ($user) {
            return $item->product->user_id === $user->id;
        }), 403);

        $order->load('items.product', 'user');

        return view('orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $user = Auth::user();

        abort_unless($user->isSeller() && $order->items->contains(function ($item) use ($user) {
            return $item->product->user_id === $user->id;
        }), 403);

        $request->validate([
            'status' => ['required', 'in:pending,confirmed,shipped,completed,cancelled'],
        ]);

        $order->update(['status' => $request->input('status')]);

        return back()->with('success', 'Order status updated.');
    }
}
