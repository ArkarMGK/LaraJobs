<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function authenticate(){
        if(Auth::user()->name == 'admin'){
            return redirect()->route('admin#dashboard');
        }
        return redirect()->route('dashboard');
    }
}
