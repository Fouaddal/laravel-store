<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        return Product::all();
    }

public function getProductById($id) {
    $product = Product::find($id);
    if ($product) {
        $product->productImage = url( $product->productImage);
        return response()->json($product, 200);
    } else {
        return response()->json(['message' => 'Product not found'], 404);
    }
}


}
