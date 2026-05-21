<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->with('items.product')
            ->latest()
            ->paginate(12);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $user = Auth::user();

        $authorized = $order->user_id === $user->id
            || $user->isAdmin()
            || ($user->isSeller() && $order->items()->whereHas('product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->exists());

        abort_unless($authorized, 403);

        $order->load('items.product', 'user');

        return view('orders.show', compact('order'));
    }

    public function store(Request $request, Product $product)
    {
        $rules = [
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $product->stock],
        ];

        // Size is required for Apparel and Footwear
        if (in_array($product->category, ['Apparel', 'Footwear'])) {
            $rules['size'] = ['required', 'string'];
        }

        $request->validate($rules);

        $quantity = $request->input('quantity');
        $size = $request->input('size');
        $total = $product->price * $quantity;

        DB::transaction(function () use ($product, $quantity, $total, $size) {
            $order = Auth::user()->orders()->create([
                'status' => 'pending',
                'total' => $total,
            ]);

            $order->items()->create([
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $quantity,
                'size' => $size,
            ]);

            $product->decrement('stock', $quantity);
        });

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function checkoutDirect(Request $request, Product $product)
    {
        $rules = [
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $product->stock],
        ];

        if (in_array($product->category, ['Apparel', 'Footwear'])) {
            $rules['size'] = ['required', 'string'];
        }

        $request->validate($rules);

        $quantity = $request->input('quantity');
        $size = $request->input('size');
        $total = $product->price * $quantity;

        $paymentMethods = [
            'credit_card' => 'Credit/Debit Card',
            'gcash' => 'GCash',
            'paypal' => 'PayPal',
            'cod' => 'Cash on Delivery',
        ];

        return view('orders.checkout-direct', compact('product', 'quantity', 'size', 'total', 'paymentMethods'));
    }

    public function processDirectCheckout(Request $request)
    {
        $paymentMethod = $request->input('payment_method');
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $size = $request->input('size');

        $product = Product::findOrFail($productId);

        $rules = [
            'payment_method' => 'required|in:credit_card,gcash,paypal,cod',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ];

        if ($size) {
            $rules['size'] = 'required|string';
        }

        if ($paymentMethod === 'credit_card') {
            $rules['card_number'] = 'required|string|min:13';
        } elseif ($paymentMethod === 'gcash') {
            $rules['gcash_number'] = 'required|string|min:10';
        } elseif ($paymentMethod === 'paypal') {
            $rules['paypal_email'] = 'required|email';
        }

        $request->validate($rules);

        $user = Auth::user();
        $total = $product->price * $quantity;

        DB::transaction(function () use ($user, $product, $quantity, $size, $total) {
            $order = $user->orders()->create([
                'status' => 'pending',
                'total' => $total,
            ]);

            $order->items()->create([
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $quantity,
                'size' => $size,
            ]);

            $product->decrement('stock', $quantity);
        });

        return redirect()->route('orders.index')->with('success', 'Order placed successfully! Payment method: ' . ucwords(str_replace('_', ' ', $paymentMethod)));
    }

    public function cancel(Order $order)
    {
        $user = Auth::user();

        // Only the buyer can cancel their own order
        abort_unless($order->user_id === $user->id, 403);

        // Can only cancel if status is not confirmed, shipped, or completed
        $cannotCancelStatuses = ['confirmed', 'shipped', 'completed', 'cancelled'];
        abort_if(in_array($order->status, $cannotCancelStatuses), 403);

        // Restore stock for all items in the order
        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->quantity);
        }

        // Update order status to cancelled
        $order->update(['status' => 'cancelled']);

        return redirect()->route('orders.index')->with('success', 'Order cancelled successfully. Stock has been restored.');
    }
}
