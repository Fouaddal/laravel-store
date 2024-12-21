<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function store(Request $request)
    {
        $cartItems = $request->input('cartItems');

        foreach ($cartItems as $item) {
            CartItem::create([
                'product_id' => $item['id'],
                'name' => $item['name'],
                'description' => $item['description'],
                'image_url' => $item['imageUrl'],
            ]);
        }

        return response()->json(['message' => 'Cart items saved successfully'], 201);
    }
}
