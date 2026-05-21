<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cartItems = Auth::user()
            ->carts()
            ->with('product')
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->getTotal();
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $user = Auth::user();
        
        // Only buyers and buyer_sellers can add to cart
        if (!$user->isBuyer()) {
            return redirect()->back()->withErrors(['cart' => 'Sellers can only sell products, not buy them.']);
        }

        $rules = [
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $product->stock],
        ];

        if (in_array($product->category, ['Apparel', 'Footwear'])) {
            $rules['size'] = ['required', 'string'];
        }

        $request->validate($rules);

        $quantity = $request->input('quantity');
        $size = $request->input('size');

        // Check if product already exists in cart (regardless of size)
        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // If product exists, update the size and replace quantity (don't add to it)
            $cartItem->update([
                'size' => $size,
                'quantity' => $quantity,
            ]);
            $message = 'Product updated in cart!';
        } else {
            // Create new cart item
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'size' => $size,
                'price' => $product->price,
            ]);
            $message = 'Product added to cart successfully!';
        }

        return redirect()->route('cart.index')->with('success', $message);
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = $cart->product;
        $quantity = $request->input('quantity');

        // Validate quantity doesn't exceed stock
        if ($quantity > $product->stock) {
            return back()->withErrors(['quantity' => 'Quantity exceeds available stock.']);
        }

        $cart->update([
            'quantity' => $quantity,
        ]);

        return back()->with('success', 'Cart updated successfully!');
    }

    public function remove(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Product removed from cart!');
    }

    public function showCheckout(Request $request)
    {
        $user = Auth::user();

        // Only buyers and buyer_sellers can checkout
        if (!$user->isBuyer()) {
            return redirect()->route('shop.index')->withErrors(['checkout' => 'Sellers cannot purchase products.']);
        }

        $selectedIds = $request->input('selected_items', []);
        
        if (empty($selectedIds)) {
            return redirect()->route('cart.index')->withErrors(['selected' => 'Please select at least one item to checkout.']);
        }

        $cartItems = $user->carts()
            ->with('product')
            ->whereIn('id', $selectedIds)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['selected' => 'Selected items not found in cart.']);
        }

        $total = $cartItems->sum(function ($item) {
            return $item->getTotal();
        });

        $paymentMethods = [
            'credit_card' => 'Credit/Debit Card',
            'gcash' => 'GCash',
            'paypal' => 'PayPal',
            'cod' => 'Cash on Delivery',
        ];

        return view('cart.checkout', compact('cartItems', 'total', 'paymentMethods', 'selectedIds'));
    }

    public function processCheckout(Request $request)
    {
        $user = Auth::user();

        // Only buyers and buyer_sellers can process checkout
        if (!$user->isBuyer()) {
            return redirect()->route('shop.index')->withErrors(['checkout' => 'Sellers cannot purchase products.']);
        }

        $paymentMethod = $request->input('payment_method');

        $rules = [
            'payment_method' => 'required|in:credit_card,gcash,paypal,cod',
            'selected_items' => 'required|array|min:1',
        ];

        // Add conditional validation for payment details
        if ($paymentMethod === 'credit_card') {
            $rules['card_number'] = 'required|string|min:13';
        } elseif ($paymentMethod === 'gcash') {
            $rules['gcash_number'] = 'required|string|min:10';
        } elseif ($paymentMethod === 'paypal') {
            $rules['paypal_email'] = 'required|email';
        }

        $request->validate($rules);

        $user = Auth::user();
        $selectedIds = $request->input('selected_items');

        $cartItems = $user->carts()
            ->with('product')
            ->whereIn('id', $selectedIds)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['selected' => 'Selected items not found in cart.']);
        }

        DB::transaction(function () use ($user, $cartItems, $paymentMethod) {
            $total = $cartItems->sum(function ($item) {
                return $item->getTotal();
            });

            $order = $user->orders()->create([
                'status' => 'pending',
                'total' => $total,
            ]);

            foreach ($cartItems as $cartItem) {
                $order->items()->create([
                    'product_id' => $cartItem->product_id,
                    'price' => $cartItem->price,
                    'quantity' => $cartItem->quantity,
                    'size' => $cartItem->size,
                ]);

                $cartItem->product->decrement('stock', $cartItem->quantity);
                $cartItem->delete();
            }
        });

        return redirect()->route('orders.index')->with('success', 'Order placed successfully! Payment method: ' . ucwords(str_replace('_', ' ', $paymentMethod)));
    }
}
