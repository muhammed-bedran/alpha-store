<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthenticationController extends Controller
{
    //
    public function index()
    {
        $user = Auth::guard('admin')->user();
        return view('dashboard.pages.two-factor-auth',[
            'user' => $user
        ]);
        // return view('dashboard.two-factor.index');
    }
}
