<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = [
            'Apparel',
            'Accessories',
            'Footwear',
            'Beauty & Personal Care',
            'Home Decor & Gifts',
            'Unique Finds',
        ];

        $query = Product::query()->available()->withSum('orderItems as total_sold', 'quantity');

        if ($search = $request->query('search')) {
            $query->where(function ($sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('seller', function ($sellerQuery) use ($search) {
                        $sellerQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($category = $request->query('category')) {
            if (in_array($category, $categories, true)) {
                $query->where('category', $category);
            }
        }

        $products = $query->orderByDesc('total_sold')->orderByDesc('created_at')->paginate(12)->withQueryString();

        return view('shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('shop.show', compact('product'));
    }
}
