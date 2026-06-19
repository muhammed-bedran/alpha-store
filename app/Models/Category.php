<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['name', 'description'];
    protected $guarded = ['created_at', 'updated_at'];
    public function products()
    {
        return $this->hasMany(Product::class);    
        //return $this->hasMany(Product::class,'category_id','id');
    }
    
}
