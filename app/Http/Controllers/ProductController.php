<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        abort_unless($user->isSeller(), 403);

        $products = $user->products()->latest()->paginate(12);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        abort_unless(Auth::user()->isSeller(), 403);

        return view('products.create');
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->isSeller(), 403);

        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'sizes' => ['nullable', 'array'],
        ]);

        $attributes['user_id'] = Auth::id();

        // Handle sizes
        if ($request->has('sizes') && is_array($request->sizes)) {
            $attributes['sizes'] = array_values(array_filter($request->sizes));
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $attributes['image'] = $imagePath;
        }

        Product::create($attributes);

        return redirect()->route('seller.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        abort_unless(Auth::user()->isSeller() && $product->user_id === Auth::id(), 403);

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        abort_unless(Auth::user()->isSeller() && $product->user_id === Auth::id(), 403);

        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'sizes' => ['nullable', 'array'],
        ]);

        // Handle sizes
        if ($request->has('sizes') && is_array($request->sizes)) {
            $attributes['sizes'] = array_values(array_filter($request->sizes));
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $attributes['image'] = $imagePath;
        }

        $product->update($attributes);

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        abort_unless(Auth::user()->isSeller() && $product->user_id === Auth::id(), 403);

        // Delete image if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Product deleted successfully.');
    }
}
