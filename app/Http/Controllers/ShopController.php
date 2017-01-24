<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

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

        Session::flash('success', 'Upload successfully');

        $book = new Book([
                'title'=>$request->input('title'),
                'author'=>$request->input('author'),
                'price'=>$request->input('price'),
                'quantity'=>$request->input('qty'),
                'image_path'=> $imagePath
            ]);

        $book->save();

    }

}
