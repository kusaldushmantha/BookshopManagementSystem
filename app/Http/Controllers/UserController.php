<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    public function getSignup(){
        return view('user.signup');
    }

    public function postSignup(Request $request){
        $this->validate($request,[
            'firstname'=>'required',
            'lastname'=>'required',
            'username'=>'required|min:5|unique:users',
            'password'=>'required|min:5|confirmed',
            'password_confirmation'=>'required|min:5',
            'contactno'=>'required|min:10|max:10|unique:users',
            'accesslevel'=>'in:admin,customer'
        ]);

        $user = new User([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            'contactno' => $request->input('contactno'),
            'accesslevel' => $request->input('accesslevel')
        ]);

        $user->save();

    }

    public function getSignin(){
        return view('shop.welcome');
    }

    public function getAddBook(){
        return view('shop.addbook');
    }
}
