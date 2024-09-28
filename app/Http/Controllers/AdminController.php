<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
   
    public function login(Request $request){
        // $request->session()->flush();
        // dd($request->session()->all());

        return view('admin.loginPage');
    }

    public function loginRequest(LoginRequest $request): RedirectResponse
    {
        $guard = $request->input('guard', 'web');

        if ($guard === 'admin') {
            $auth = Auth::guard('admin');
            $model = AdminModel::class;
        } else {
            $auth = Auth::guard('web');
            $model = User::class;
        }
        $credentials = $request->only('email', 'password');
        if ($auth->attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->route('admin_dashboard');
        }
       return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function index() {
        return view('admin.dashboard');
    }
  
}
