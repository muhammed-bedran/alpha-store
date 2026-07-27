<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
    protected $table = 'order_items';
    protected $fillable = ['order_id', 'product_id', 'store_id','quantity', 'price', 'product_name'];
                            // 1        1              1           3         1000        iphone
                            //1        1              2           3         1000     laptop   

    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function store(){
        return $this->belongsTo(Store::class);
    }
}
