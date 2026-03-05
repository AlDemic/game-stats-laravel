<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthenticationController extends Controller
{
    //global var for admin
    private const ADMIN_LOGIN = 'admin'; 
    private const ADMIN_PASSWORD = '1212'; 

    //func to check if admin or show form to login
    public function isAdmin() {
        //redirect
        if(session('is_admin')) {
            return redirect('/admin');
        }

        //show form
        return view('admin.login');
    }

    //login func
    public function adminLogin(Request $request) {
        //form validation
        $validated = $request->validate([
            'login' => 'required|string|min:3|max:12',
            'password' => 'required|string|min:3|max:12'
        ]);

        //authentication
        if($validated['login'] === self::ADMIN_LOGIN && $validated['password'] === self::ADMIN_PASSWORD) {
            $request->session()->regenerate();
            $request->session()->put('is_admin', true);

            return redirect('/admin');
        }

        //if errors
        return back()->withErrors([
            'msg' => 'Login or password wrong'
        ]);
    }
}
