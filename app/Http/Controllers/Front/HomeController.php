<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(){
        // $locale = app()->getLocale();
        // $products =Product::query()
        // ->VisibleForLocale($locale)
        // ->leatest()
        // ->get()
        // ->filter(fn(Product $product) => $product->isVisibleForLocale($locale))
        // ->values();
        return view('front.pages.index');
    }
}
