<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('user.auth.login');
    }

    public function store(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        
        if (Auth::attempt($credentials)) {
            return redirect('/dashboard');
        } else {
            return redirect()->back()->with('status', 'Email hoặc Password không chính xác');
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }
}

