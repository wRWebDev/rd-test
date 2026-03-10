<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('products.index', [
            'products' => Product::all(),
        ]);
    }

    public function show(Product $product): View
    {
        return view('products.show', [
            'product' => $product->load('warehouses'),
        ]);
    }
}
