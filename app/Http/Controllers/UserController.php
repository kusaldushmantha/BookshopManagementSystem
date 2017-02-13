<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
            'email'=>'email|required',
            'accesslevel'=>'in:admin,customer'
        ]);

        $user = new User([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            'email' => $request->input('email'),
            'accesslevel' => $request->input('accesslevel')
        ]);

        $user->save();
        try{
            if(Auth::user()->accesslevel=='admin'){
                $this->getsignupemail();
                return redirect()->route('admindash')->with('adminsuccess','Account created Successfuly');

            }
        }catch (\Exception $e){
            $this->getsignupemail();
            return redirect()->route('signin')->with('customersuccess','Account created Successfuly, Sign-in to Continue');
        }

    }

    public function getsignupemail(){
        $user = User::orderBy('id','desc')->first();
        Mail::send('emails.signupemail', ['user' => $user], function ($m) use ($user) {
            $m->from('treehousebookstore3@gmail.com', 'TreeHouse Books');

            $m->to($user->email)->subject('Thank You For Subscribing To TreeHouseBooks!');
        });
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
        return view('user.customerdash',['books'=>$book]);

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
                ->with('updatedanger','Entered Old Password Does not match with Current Password');
        }
        if($request->input('oldpassword'))
        $user = DB::table('users')->where(['id'=>$request->input('id')])->update(['username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),'email' => $request->input('email')]);
        if(Auth::user()->accesslevel=="admin"){
            return redirect()->route('admindash')->with('adminupdatesuccess','Account Successfully Updated');
        }else{
            return redirect()->route('customerdash')->with('customerupdatesuccess','Account Successfully Updated');
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

    public function getViewOrders(){
        $orderDetails = DB::table('adminorders')->get();
        return view('user.vieworders',['orderDetails'=>$orderDetails]);
    }

    public function getShipOrder($id){
        $purchase = DB::table('orders')->where(['id'=>$id])->get();
        $user_id = DB::table('orders')->where(['id'=>$id])->value('user_id');
        $user = DB::table('users')->where(['id'=>$user_id])->first();
        Mail::send('emails.shippedemail', ['user' => $user,'purchase'=>$purchase[0]], function ($m) use ($user) {
            $m->from('treehousebookstore3@gmail.com', 'TreeHouse Books');

            $m->to($user->email)->subject('Order Shipped - TreeHouse Books');
        });
        DB::table('orders')->where(['id'=>$id])->update(['order_status' => 'Shipped']);
        DB::table('adminorders')->where(['order_id'=>$id])->update(['order_status' => 'Shipped']);

        return redirect()->route('vieworders')->with('shippedsuccess');

    }

    public function getConfirmationOnRecieved($id){
        $orderDetails = DB::table('orders')->where(['id'=>$id])->get();
        $user_id = DB::table('orders')->where(['id'=>$id])->value('user_id');
        DB::table('orders')->where(['id'=>$id])->update(['order_status' => 'Confirmed']);
        DB::table('adminorders')->where(['order_id'=>$id])->update(['order_status' => 'Confirmed']);
        return redirect()->route('getmypurchase')->with('confirmedsuccess');
    }

    //$p->id = OrderId in Orders Table

    public function getDeleteThisPurchase($orderId){
        DB::table('orders')->where(['id'=>$orderId])->delete();
        return redirect()->route('getmypurchase')->with('purchasedelete');
    }

    public function getDeleteAdminOrder($orderId){
        DB::table('adminorders')->where(['id'=>$orderId])->delete();
        return redirect()->route('vieworders')->with('deletesuccess');
    }


}
