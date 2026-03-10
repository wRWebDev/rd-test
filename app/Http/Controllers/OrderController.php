<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
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
        return view('orders.thank-you');
    }
}
