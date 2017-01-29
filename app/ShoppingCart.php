<?php
/**
 * Created by PhpStorm.
 * User: Kusal
 * Date: 2017-01-29
 * Time: 8:15 AM
 */

namespace App;


class ShoppingCart
{

    public $books = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    function __construct($oldCart)
    {
        if($oldCart!=null){
            $this->books = $oldCart->books;
            $this->totalPrice = $oldCart->totalPrice;
            $this->totalQty = $oldCart->totalQty;
        }
    }

    public function addBook($book,$id){
        $storedItems = ['book'=>$book,'price'=>$book->price,'qty'=>0];
        if($this->books){
            if(array_key_exists($id,$this->books)){
                $storedItems = $this->books[$id];
            }
        }
        $storedItems['qty']++;
        $storedItems['price'] = $book->price * $storedItems['qty'];
        $this->books[$id] = $storedItems;
        $this->totalQty++;
        $this->totalPrice += $book->price;;

    }

    public function reduceByOne($id){
        $this->books[$id]['qty']--;
        $this->books[$id]['price'] -= $this->books[$id]['book']['price'];
        $this->totalQty--;
        $this->totalPrice -= $this->books[$id]['book']['price'];

        if($this->books[$id]['qty']<=0){
            unset($this->books[$id]);
        }
    }

    public function reduceAll($id){
        $this->totalQty -= $this->books[$id]['qty'];
        $this->totalPrice -= $this->books[$id]['price'];
        unset($this->books[$id]);
    }


}