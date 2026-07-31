<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CartService
{
    public function getOrCreateCart()
    {
        $sessionId = session()->getId();
        $userId =Auth::id();
        if($userId)
            {
                $cart =Cart::query()->firstOrCreate(
                    ['user_id' => $userId],
                    ['session_id' => $sessionId]
                );

            if ($cart->session_id !== $sessionId) {
                $cart->update(['session_id' => $sessionId]);
            }
            return $cart->load('items.product');

            }
        return Cart::query()->firstOrCreate(
            ['session_id' => $sessionId , 'user_id'=>null],
            []
        );
           
    }
    public function items()
    {
        return $this->getOrCreateCart()
        ->items()
        ->with('product.store','product.category')
        ->whereHas('product',fn($q)=>$q->where('status','active'))
        ->get();
    }
    public function count()
    {
        return (int) $this->items()->sum('quantity');
    }
    // سعر المنتج  X الكمية
    public function subtotal(){
        return (float) $this->items()->sum(fn(CartItem $item) => $item->lineTotal());
    }



    public function add(Product $product, int $quantity = 1){
        if($product->status !== 'active'){
            throw ValidationException::withMessages([
                'product_id' => 'Product is not active'
            ]);
        }
        $cart = $this->getOrCreateCart();
        $item = CartItem::query()->firstOrNew([

            'cart_id' => $cart->id,
            'product_id' => $product->id
        ]);
        $item->quantity = ($item->exists ? $item->quantity : 0) + $quantity;
        $item->save();
        return $item;
    }
    protected function ensureOwnsItem(CartItem $item){
        if($item->cart_id !== $this->getOrCreateCart()->id){
            abort(403);
        }
    }
    
    public function updateQty(CartItem $item, int $quantity){
        $this->ensureOwnsItem($item);
        if($quantity < 1){
            $item->delete();
            return;
        }
        $item->update([
            'quantity' => $quantity
        ]);
    }
    public function remove(CartItem $item){
        $this->ensureOwnsItem($item);
        $item->delete();
    }
    public function clear(){
        $cart = $this->getOrCreateCart();
        $cart->items()->delete();
    }
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
}
