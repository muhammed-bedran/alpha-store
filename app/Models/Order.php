<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    //
    protected $table = 'orders';
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'phone',
        'address',
        'note',
        'payment_method',
        'shipping_cost',
        'total',
        'subtotal',
        'status',
    ];
    // malak order table
    // 1 2 3 4 5  order_items
     protected static function booted(){  // ORD-20260727-ABCD
        static::creating(function(Order $order){
            if(empty($order->order_number)){
                $order->order_number = 'ORD-'.now()->format('ymd').'-'.Str::upper(Str::random(4));
            }
        });
     }

     public function user(){
        return $this->belongsTo(User::class);
     }
     public function items()
     {
         return $this->hasMany(OrderItem::class);
     }
}
// muhammed bedran  // ORD-20260727-ABCD
// laptop
// iphone   
// mouse