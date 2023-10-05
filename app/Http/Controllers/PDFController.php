<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PDFController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->session()->has('username') == FALSE) {
            return redirect()->action([UserController::class, 'login']);
        }
        return view('pdf.index');
    }
    
    public function importar(Request $request)
    {
        if ($request->session()->has('username') == FALSE) {
            return redirect()->action([UserController::class, 'login']);
        }
        return view('pdf.importar');
    }
    
    public function convertir(Request $request)
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

}