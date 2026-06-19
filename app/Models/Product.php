<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'store_id',
        'image',
        'status',
        'compare_price',
        'rating'

    ];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
