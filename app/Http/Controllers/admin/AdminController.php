<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function profile()
    {
        $user = User::where('id', Auth::user()->id)->first();
        // dd($user->toArray());
        return view('admin.profile.index', compact('user'));
    }
}
