<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        if (session()->has('admin_id')) {
            return redirect()->route('admin.dashboard'); // Redirect to dashboard if already logged in
        }
        return view('admin.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Session::put('admin_id', $admin->id);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid email or password.');
    }

    public function dashboard()
    {
        if (!Session::has('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Please log in first.');
        }

        return view('admin.dashboard');
    }

    public function logout()
    {
        Session::forget('admin_id');
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
