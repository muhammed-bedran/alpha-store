<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user()->load('store');
        $stats = [
            'products_count' => 0,
            'teams_count' => 0,
            'store_status' => null,
        ];
        if($user->hasStore())
            {
                $store = $user->store;
                $stats['products_count'] = $store->products()->count();
                $stats['teams_count'] = $store->users()->count();
                $stats['store_status'] = $store->status;
            }
            return view('user.pages.index', compact('stats','user'));

    }
}
