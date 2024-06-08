<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::getContent();
        $total = Cart::getTotal();
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $product = Product::find($request->id);

        Cart::add(array(
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->quantity,
            'attributes' => array('image' => $product->image)
        ));

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function update(Request $request)
    {
        Cart::update($request->id, array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->quantity
            ),
        ));

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    public function remove(Request $request)
    {
        Cart::remove($request->id);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    public function checkout()
    {
        $cartItems = Cart::getContent();
        $total = Cart::getTotal();
        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function processCheckout(Request $request)
    {
        // Example: process the order and clear the cart

        // Clear the cart
        Cart::clear();

        return redirect()->route('products.index')->with('success', 'Order placed successfully!');
    }
}
