<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\AdminLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{

    public function __construct()
    {
        //Login Page can be viewd by anyone
        $this->middleware("guest:admin");
    }

    /**
     * Return Login form
     */
    public function show()
    {
        return view('admin.login');
    }

    public function login(AdminLogin $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->guard('admin')->attempt($credentials))
        {
            return redirect()->route('dashboard')->with('login_success',__('admin.success_login'));
        } else {
            return back()->withInput()->with('wrong_fields', __('admin.wrong_fields'));
        }
    }

    public function logout()
    {
        if(auth()->guard('admin')->check())
        {
            auth()->guard('admin')->logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect()->route('login.show')->with('logout', __('success_logout'));
        }

    }


}

