<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    //
    public function __construct(protected CartService $cart) {}
    public function create()
    {
        $items = $this->cart->items();
        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }
        return view('front.pages.checkout.create', [
            'items' => $items,
            'subtotal' => $this->cart->subtotal(),
            'total' => $this->cart->subtotal(),
        ]);
    }
    public function store(Request $request)
    {

        $items = $this->cart->items();
        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }
        $inactive = $items->first(fn($item) => !$item->product || $item->product->status !== 'active');
        if ($inactive) {
            return back()->with('error', 'Product is not active');
        }
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);
        $subtotal = $this->cart->subtotal();
        $order = DB::transaction(function () use ($data, $subtotal,$items) {
            
        $order=Order::create([
            'user_id' => Auth::id(),
            'customer_name' => $data['customer_name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'note' => $data['note'],
            'payment_method' => 'cash_on_delivery',
            'shipping_cost' => 0,
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'status' => 'pending',
        ]);
        foreach ($items as $item)
            {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'store_id' => $item->product->store_id,
                    'price' => $item->product->price,
                    'product_name' => $item->product->name,
                    
                ]);
            }

            $this->cart->clear();
            return $order;

        });
        return redirect()->route('checkout.success',$order)
        ->with('success', 'Order placed successfully');
    }
    public function success(Order $order)
    {
        return view('front.pages.checkout.success', [
            'order' => $order,
        ]);
    }
}
