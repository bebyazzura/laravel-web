<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cartItem = Cart::where('user_id', Auth::id())->get();
        $grandTotal = $this->grandTotal($cartItem);
        $products = Product::all();

        return view('home', compact('user', 'cartItem', 'grandTotal', 'products'));
    }


    public function addToCart(Request $request, $id)
    {

        // Get the current user
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }

        // Get the product ID and quantity from the request
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // // Get the product from the database
        $product = Product::findOrFail($id);

        // // Add the product to the user's cart
        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('name', $product->name)
            ->where('price', $product->price)
            ->where('image', $product->image)
            ->where('quantity', $quantity)
            ->first();

        if ($cartItem) {
            // If the item already exists, update the quantity
                $cartItem->quantity += $quantity;
                $cartItem->save();
        } else {
            // If the item does not exist, create a new cart item
            $cartItem = new Cart();
            $cartItem->user_id = $user->id;
            $cartItem->product_id = $product->id;
            $cartItem->name = $product->name;
            $cartItem->price = $product->price;
            $cartItem->image = $product->image;
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        // Redirect the user to the cart page
        return redirect('/home');
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cartItem = new Cart([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'name' => $request->name,
                'price' => $request->price,
                'image' => $request->image,
                'quantity' => $request->quantity
            ]);
            $cartItem->save();
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function destroy(Cart $cartItem)
    {
        $cartItem->delete();
        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function grandTotal()
    {
        $userId = auth()->id();
        $cartItem = Cart::where('user_id', $userId)->get();

        $grandTotal = 0;

        foreach ($cartItem as $item) {
            $grandTotal += $item->product->price * $item->quantity;
        }

        return $grandTotal;
    }


    // public function update(Request $request, Cart $cartItem)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'quantity' => 'required|integer|min:1',
    //         'price' => 'required|numeric|min:0',
    //     ]);

    //     // Update the cart item with the new quantity and price
    //     $cartItem->quantity = $request->input('quantity');
    //     $cartItem->product->price * $cartItem->quantity = $request->input('price');
    //     $cartItem->push();

    //     // Redirect the user back to the cart page with a success message
    //     return redirect()->route('home')->with('success', 'Cart item updated successfully.');
    // }

    public function update(Request $request, Cart $cartItem)
    {
        // Validate the request
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // Update the cart item with the new quantity and price
        $cartItem->quantity = $request->input('quantity');
        $cartItem->price = $cartItem->quantity * $cartItem->product->price = $request->input('price');
        // $cartItem->total_price = 
        $cartItem->save();

        // Redirect the user back to the cart page with a success message
        return redirect()->route('home')->with('success', 'Cart item updated successfully.');
    }
}
