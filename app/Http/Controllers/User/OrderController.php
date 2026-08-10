<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
        $store = Auth::user()->store;
        $query = Order::query()
            ->forStore($store->id)
            ->with([
                'items' => fn($q) => $q->where('store_id', $store->id),
            ]);
        if ($orderNumber = $request->query('order_number')) {
            $query->where('order_number', $orderNumber);
        }
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }
        $orders = $query->latest()->paginate(10);
        return view('user.pages.orders.index', compact('orders'));
    }
    protected function authorizeStoreOrder(Order $order,int $storeId)
    {
        $belongsToStore = $order->items()->where('store_id', $storeId)->exists();
        if (!$belongsToStore) {
            abort(403);
        }
    }
    public function show(Order $order)
    {
        $store = Auth::user()->store;
        $this->authorizeStoreOrder($order, $store->id);
        $storeItems = $order->items()
        ->where('store_id', $store->id)
        ->get();
        $storeTotal = $storeItems->sum(fn($item)=> $item->lineTotal());
       return view('user.pages.orders.show', compact('order', 'storeItems', 'storeTotal','store'));
    }

}
