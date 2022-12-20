<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DateTime;


class AuthController extends Controller
{

    public function showLogin(){
        return view('auth.login');
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('home')
                        ->withSuccess('Signed in');
        }
  
        return redirect("home")->withSuccess('Login details are not valid');
    }

    public function showRegister(){
        return view("auth.register");
    }

    public function register(Request $req){
        $req->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|string|confirmed',
        ]);
           
        // $data = $request->all();
        $data = [
            'first_name' => $req->first_name,
            'last_name' => $req->last_name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'phone_number' => $req->phone_number,
            'unique_id' => md5(uniqid()),
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $check = $this->create($data);
        
        return redirect("api/login")->withSuccess('You have signed-in');
    }

    public function create(array $data){
        return User::create($data);        
    }

    public function signout() {
        Session::flush();
        Auth::logout();  
        return Redirect('home');
    }
}
