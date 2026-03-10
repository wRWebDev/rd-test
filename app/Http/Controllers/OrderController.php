<?php

namespace App\Http\Controllers;

use Closure;
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
        /** @var ?Product $product */
        $product = null;

        $request->validate([
            'product' => 'required|string|exists:products,uuid',
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function (string $attribute, mixed $value, Closure $fail) use ($request, &$product) {
                    $product = Product::findOrFail($request->input('product'));
                    if ((int) $value > $product->immediateDespatch()) {
                        $fail('Not enough stock to satisfy the order');
                    }
                },
            ],
        ]);

        $quantity = $request->integer('quantity');

        if (is_null($product)) {
            $product = Product::findOrFail($request->input('product'));
        }

        $order = Order::create([
            'status' => OrderStatus::PLACED,
            'total' => $product->price * $quantity,
        ]);

        $order->addProduct($product, $quantity);

        return view('orders.thank-you', ['order' => $order]);
    }
}
