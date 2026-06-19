<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
   protected $fillable = [
    'name',
    'description',
    'logo',
    'status',
   ];
   public function products()
    {
     return $this->hasMany(Product::class);
    }
    public function users()
    {
     return $this->hasMany(User::class,'store_id','id');
    }
}
