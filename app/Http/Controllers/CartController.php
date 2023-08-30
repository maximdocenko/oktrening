<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    public function addToCart($id): JsonResponse
    {
        $product = Product::find($id);

        if(!$product) {

            return response()->json(null, Response::HTTP_NOT_FOUND);

        }

        $cart = session()->get('cart');

        // Если нет продуктов в корзине

        if(!$cart) {

            $cart = [
                $id => [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "file" => $product->file
                ]
            ];

            session()->put('cart', $cart);

            return response()->json($cart);

        }

        // Если уже добавлен такой продукт

        if(isset($cart[$id])) {

            $cart[$id]['quantity']++;

            session()->put('cart', $cart);

            return response()->json($cart);

        }

        // Новый продукт

        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "file" => $product->file
        ];

        return response()->json($cart);
    }

    public function update(CartRequest $request): JsonResponse
    {
        $cart = session()->get('cart');

        if($request->quantity)
        {
            $cart[$request->id]["quantity"] = $request->quantity;

            session()->put('cart', $cart);
        }

        return response()->json($cart);
    }

    public function remove(CartRequest $request): JsonResponse
    {
        $cart = session()->get('cart');

        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }

        return response()->json($cart);
    }
}
