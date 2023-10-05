<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    public function login(Request $request): View
    {
        return view('login');
    }
    
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
 
        //if (Auth::attempt($credentials)) {
        if(trim($request->username) == "admin" && trim($request->password) == "1234"){
            $request->session()->regenerate();
            session(['username' => 'admin']);
            return redirect()->action([PDFController::class, 'index']);
            //return redirect()->intended('pdf.index');
            //return redirect('pdf.index');
        }
 
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        $request->session()->regenerate();
        $request->session()->invalidate();
        return redirect()->action([PDFController::class, 'index']);
    }

}