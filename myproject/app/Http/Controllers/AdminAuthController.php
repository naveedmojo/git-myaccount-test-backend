<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    
    
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $admin = Admin::where('email', $request->email)->first();

    if (!$admin) {
        return back()->withErrors(['email' => 'The email does not exist.'])->withInput();
    }

    if (!Auth::guard('admin')->attempt($request->only('email', 'password'))) {
        return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
    }

  
    return redirect()->route('admin.dashboard')->with('success', 'Login successful! Welcome back.');
}

public function logout(Request $request)
{
    Auth::guard('admin')->logout();

    // Ensure session is cleared properly
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login'); // Ensure this matches your named route
}

}
