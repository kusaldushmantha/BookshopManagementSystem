<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

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
            'contactno'=>'required|min:10|max:10',
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
        if(Auth::user()->accesslevel=='admin'){
            return redirect()->route('admindash')->with('success','Account created Successfuly');
        }
        return redirect()->route('signin')->with('success','Account created Successfuly, Sign-in to Continue');

    }

    public function getSignin(){
        return view('user.signin');
    }

    public function postSignin(Request $request){
        $this->validate($request,[
            'username'=>'required|min:5',
            'password'=>'required|min:5'
        ]);

        if(Auth::attempt(['username'=>$request->input('username'),'password'=>$request->input('password'),
            'accesslevel'=>'admin'])){
            return redirect()->route('admindash');
        }else if (Auth::attempt(['username'=>$request->input('username'),'password'=>$request->input('password'),
            'accesslevel'=>'customer'])){
            return redirect()->route('customerdash');
        }else{
            $errors = new MessageBag(['password' => ['Username and/or password invalid.']]);
            return Redirect::back()->withErrors($errors)->withInput(Input::except('password'));
        }

    }

    public function getCustomerDash(){
        $book = Book::paginate(15);
        if(Auth::user()->accesslevel=="customer"){
            return view('user.customerdash',['books'=>$book]);
        }else{
            return view('user.admindash',['books'=>$book]);
        }

    }

    public function getLogout(){
        Auth::logout();
        return redirect()->route('signin');
    }

    public function getUpdateAccount($id){
        $user = User::find($id);
        return view('user.updateaccount',['user'=>$user]);
    }

    public function postUpdateAccount(Request $request){
        $oldp = DB::table('users')->where(['id'=>$request->input('id')])->pluck('password')[0];
        if(!Hash::check($request->input('oldpassword'),$oldp)){
            return redirect()->route('updateaccount',['id'=>$request->input('id')])
                ->with('danger','Entered Old Password Does not match with Current Password');
        }
        if($request->input('oldpassword'))
        $user = DB::table('users')->where(['id'=>$request->input('id')])->update(['username' => $request->input('username'),
            'password' => bcrypt($request->input('password'))]);
        if(Auth::user()->accesslevel=="admin"){
            return redirect()->route('admindash')->with('success','Account Successfully Updated');
        }else{
            return redirect()->route('customerdash')->with('success','Account Successfully Updated');
        }

    }

    public function getMyPurchase(){
        $purchase = Auth::user()->orders;
        $purchase->transform(function ($order,$key){
            $order->cart = unserialize($order->cart);
            return $order;
        });

        return view('user.purchase',['purchase'=>$purchase]);
    }

}
