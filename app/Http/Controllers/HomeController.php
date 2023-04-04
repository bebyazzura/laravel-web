<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', Auth::id())->get();
        $grandTotal = $this->grandTotal($cart);
        $products = Product::all();
        return view('home', compact('user','cartItems', 'grandTotal', 'products'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);

        if (!$product) {
            abort(404);
        }

        $cart = session()->get('cart');

        if (!$cart) {
            $cart = [
                $request->id => [
                    "name" => $product->name,
                    "image" => $product->image,
                    "quantity" => 1,
                    "price" => $product->price
                ]
            ];

            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity']++;
            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

        $cart[$request->id] = [
            "name" => $product->name,
            "image" => $product->image,
            "quantity" => 1,
            "price" => $product->price
        ];

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

}
