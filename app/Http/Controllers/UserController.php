<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use PDOException;

class UserController extends Controller
{
    public function create(){
        return view('auth.register');
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $request['password'] = bcrypt($request->password);
            $user = User::create($request->all());
            
            DB::commit();
            return redirect()->route('auth.login');
        } catch (PDOException $e) {
           DB::rollBack();
           dd($e->getMessage());

       }
    }

    public function login(){
        return view('auth.login');
    }

    public function authenticate(Request $request){
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if(!$user){
            return redirect()->route('auth.login')->withErrors(['message' => 'Email or Password is invalid!']);
        }

        if(Hash::check($password, $user->password)){
            Auth::loginUsingId($user->id);
            return redirect()->route('app.home');
        }

        return redirect()->route('auth.login')->withErrors(['message' => 'Email or Password is invalid!']);
    }

    public function logout(){
        if(Auth::check()){
            Auth::logout();
        }

        return redirect()->route('auth.login');
    }

}
