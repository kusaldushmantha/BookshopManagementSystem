<?php

namespace App\Http\Controllers;

use App\Book;
use App\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;

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

}
