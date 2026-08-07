<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Services\CartService;
class Cart extends Component
{
    public int $count;
    public float $subtotal;
    public $items;
    /**
     * Create a new component instance.
     */
    public function __construct(CartService $cart)
    {
        //
        $this->items = $cart->items();
        $this->count = (int) $this->items->sum('quantity');
        $this->subtotal = (float) $this->items->sum(fn($item) => $item->lineTotal());
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart');
    }
}
