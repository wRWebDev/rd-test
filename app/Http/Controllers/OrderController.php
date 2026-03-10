<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;
use App\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;

class OrderController extends Controller
{
    public function showForm(): View
    {
        return view('orders.form', [
            'products' => Product::all(),
        ]);
    }

    public function store(FormRequest $request): View
    {
        $request->validate([
            'product' => 'required|string|exists:products,uuid',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->input('product'));
        $quantity = $request->integer('quantity');

        $order = Order::create([
            'status' => OrderStatus::PLACED,
            'total' => $product->price * $quantity,
        ]);

        $order->addProduct($product, $quantity);

        return view('orders.thank-you', ['order' => $order]);
    }
}
