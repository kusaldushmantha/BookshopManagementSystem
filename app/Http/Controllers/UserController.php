<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;

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

    public function postSignin(Request $request){
        $this->validate($request,[
            'username'=>'required|min:5',
            'password'=>'required|min:5'
        ]);

        if(Auth::attempt(['username'=>$request->input('username'),'password'=>$request->input('password')])){
            return redirect()->route('addbook');
        }else{
            $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);
            return Redirect::back()->withErrors($errors)->withInput(Input::except('password'));
        }

    }

    public function getAddBook(){
        return view('shop.addbook');
    }
}
