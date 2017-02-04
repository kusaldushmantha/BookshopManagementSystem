<?php

namespace App\Http\Controllers;

use App\Book;
use App\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use DateTime;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;

class ShopController extends Controller
{

    public function getAddBook(){
        return view('shop.addbook');
    }

    public function postAddBook(Request $request){
        $this->validate($request,[
            'title'=>'required|unique:books',
            'author'=>'required',
            'price'=>'required',
            'qty'=>'required',
            'image'=>'required'
        ]);

        $file = $request->file('image');
        $imagePath = $file->move('covers',$file->getClientOriginalName());

            $book = new Book([
                'title'=>$request->input('title'),
                'author'=>$request->input('author'),
                'price'=>$request->input('price'),
                'quantity'=>$request->input('qty'),
                'image_path'=> $imagePath]);

            $book->save();

            return redirect()->back()->with('success','Book Successfully Added');


    }

    public function getAdmindash(){
        $book = Book::paginate(9);
        return view('user.admindash',['books'=>$book]);
    }

    public function getViewStore(){
        $book = Book::paginate(20);
        return view('shop.viewstore',['books'=>$book]);
    }

    public function getShoppingCart(){
        if(!Session::has('cart')){
            return view('user.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new ShoppingCart($oldCart);
        return view('user.shopping-cart',['books'=>$cart->books,'totalPrice'=>$cart->totalPrice]);
    }

    public function getUpdateBook($id){
        $book = Book::find($id);
        return view('shop.updatebook',['book'=>$book]);
    }

    public function postUpdateBook(Request $request){

        $date = new DateTime();

        $book = DB::table('books')->where(['id'=>$request->input('id')])->update(['price' => $request->input('price'),
        'quantity' => $request->input('qty')]);

        return redirect()->route('viewstore')->with('success','Book Successfully Updated');
    }

    public function getAddtoCart(Request $request,$id){
        $book = Book::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart'):null;
        $shoppingCart = new ShoppingCart($oldCart);
        $shoppingCart->addBook($book,$book->id);

        Session::put('cart',$shoppingCart);

        return redirect()->route('customerdash')->with('success', $book->title.' Added to Cart');
    }

    public function getReduceAll($id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new ShoppingCart($oldCart);
        $cart->reduceAll($id);

        if(count($cart->books)>0){
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
            return redirect()->route('customerdash');
        }
        return redirect()->route('shoppingcart');
    }

    public function getReduceByOne($id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new ShoppingCart($oldCart);
        $cart->reduceByOne($id);

        if(count($cart->books)>0){
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
            return redirect()->route('customerdash');
        }
        return redirect()->route('shoppingcart');
    }

    public function getCheckout(){
        if(!Session::has('cart')){
            return view('user.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new ShoppingCart($oldCart);
        $total = $cart->totalPrice;
        return view('shop.checkout',['total'=>$total]);
    }


    public function postCheckout(Request $request){
        if(!Session::has('cart')){
            return redirect()->route('shoppingcart');
        }
        $oldCart = Session::get('cart');
        $cart = new ShoppingCart($oldCart);
        Stripe::setApiKey('sk_test_U65gLxf4AtyH03N0RUWzOitd');

        $date = new DateTime();

        try{
            $charge = \Stripe\Charge::create(array(
                "amount" => $cart->totalPrice *100,
                "currency" => "usd",
                "description" => $request->input('name').' '.'checkout on '.$date->getTimestamp(),
                "source" => $request->input('stripeToken'),
            ));
        }catch(\Exception $e){
            return redirect()->route('checkout')->with('error',$e->getMessage());
        }

        Session::forget('cart');

        if(Auth::user()->accesslevel=='admin'){
            return redirect()->route('admindash')->with('success','Books Purchased Successfully');
        }else{
            return redirect()->route('customerdash')->with('success','Books Purchased Successfully');
        }
    }

}
