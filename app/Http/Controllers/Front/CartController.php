<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function __construct(protected CartService $cart)
    {
        
    }
    public function index()
    {
        return view('front.pages.cart.index',[
            'items' =>  $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
            'total'=> $this->cart->subtotal(),
         
        ]);
    }
    public function store(Request $request)
    {
       $data = $request->validate([
        'product_id' => ['required','exists:products,id'],
        'quantity' => ['required','integer','min:1','max:99'],
       ]) ;
       $product = Product::query()->findOrFail($data['product_id']);
       $this->cart->add($product,(int) ($data['quantity'] ?? 1));
       return back()->with('success','Product added to cart successfully');

    }
    public function update(Request $request, CartItem $cartItem)
    {
        $data = $request->validate([
            'quantity' => ['required','integer','min:1','max:99'],
        ]);
        $this->cart->updateQty($cartItem,(int) $data['quantity']);
    }
    public function destroy(CartItem $cartItem)
    {
        $this->cart->remove($cartItem);
    }
}
