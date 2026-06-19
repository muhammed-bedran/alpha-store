<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;

use App\Models\Category;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $stats =[
            'products_count' => Product::count(),
            'categories_count' => Category::count(),
            'stores_count' => Store::count(),
            'users_count' => User::count(),
        ];
        return view('dashboard.pages.index', compact('stats'));
    }
}
