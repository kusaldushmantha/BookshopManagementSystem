<?php

namespace App\Http\Controllers;

use App\Book;
use App\Order;
use App\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use DateTime;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\Cast\Object_;
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

    public function getEmptyStocks(){
        $book = Book::where('quantity',0)->paginate(20);
        return view('shop.emptystock',['books'=>$book]);
    }

    public function getRunningOutStocks(){
        $book = Book::whereBetween('quantity',[1,10])->paginate(20);
        return view('shop.runningout',['books'=>$book]);
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
        if(Auth::user()->accesslevel=="customer"){
            return redirect()->route('customerdash')->with('success', $book->title.' Added to Cart');
        }else{
            return redirect()->route('admindash')->with('success', $book->title.' Added to Cart');
        }

    }

    public function getReduceAll($id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new ShoppingCart($oldCart);
        $cart->reduceAll($id);

        if(count($cart->books)>0){
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
            if(Auth::user()->accesslevel=="customer"){
                return redirect()->route('customerdash');
            }else{
                return redirect()->route('admindash');
            }

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
            if(Auth::user()->accesslevel=="customer"){
                return redirect()->route('customerdash');
            }else{
                return redirect()->route('admindash');
            }
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
        $bookArray = null;

        try{

            foreach ($cart->books as $book){
                $bookArray[$book['book']['id']]=$book['qty'];
            }

            foreach($bookArray as $x => $x_value) {
                $qtyCurrent = DB::table('books')->where(['id'=>$x])->value('quantity');
                DB::table('books')->where(['id'=>$x])->update(['quantity' => $qtyCurrent-$x_value]);
            }

            $charge = \Stripe\Charge::create(array(
                "amount" => $cart->totalPrice *100,
                "currency" => "usd",
                "description" => $request->input('name').' '.'checkout on '.$date->getTimestamp(),
                "source" => $request->input('stripeToken'),
            ));

            $order = new Order();
            $order->cart = serialize($cart);
            $order->address = $request->input('address');
            $order->customername = $request->input('name');
            $order->payment_id = $charge->id;


            Auth::user()->orders()->save($order);

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

    public function getDeleteBook($id){
        DB::table('books')->where(['id'=>$id])->delete();
        return redirect()->route('admindash')->with('success','Books Removed Successfully');
    }

}
