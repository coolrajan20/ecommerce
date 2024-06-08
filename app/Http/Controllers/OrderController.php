<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store() {
        $cartItems = Cart::where('user_id', auth()->id())->get();
        $totalPrice = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
    
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);
    
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }
    
        Cart::where('user_id', auth()->id())->delete();
        return redirect()->route('orders.show', $order->id);
    }
    
}
