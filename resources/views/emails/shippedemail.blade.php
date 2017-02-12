@extends('layout.master')

<body>
<div class="emailtitle">
    <strong>TreeHouse Books</strong>
</div>
<div class="container emailbody">
    <p><br>Hello {{$user->username}}!
        <br><br>

        Your order Purchased on : {{$purchase->updated_at}} was Shipped today.
        <br><br>
    <div class="panel panel-success panelModify">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Order Details : </strong></h3>
        </div>
        <div class="panel-body">
            <ul class="list-group">
                @php($cart = unserialize($purchase->cart))
                @foreach($cart->books as $book)
                    <hr>
                    <li class="list-group-item">
                        <strong>Book Title : {{ $book['book']['title'] }}</strong>
                        <br>
                        <strong>Quantity : {{ $book['qty'] }}</strong>
                        <br>
                        <strong>Price : ${{ $book['price'] }}</strong>
                        <br>
                    </li>
                    <hr>
                @endforeach
            </ul>
        </div>
        <div class="panel-footer"><strong>Total Price Paid: ${{ $cart->totalPrice }}</strong></div>
        <hr>
        <br>
        <strong>Upon Recieval of the Order, Please Be Kind to Confirm on 'My Purchases' tab on your Account</strong>
        <br><br>
        If not recieved within 2-7 working days. Please do not hesitate to contact us at TreeHouse Books.
        <br><br>
    </div>
    <br>
    Thank you for Shopping with Us.
    <br><br>
    Happy Reading.. !!!
    <br><br>
    Sincerely,
    <br>
    TreeHouse People :)
    </p>
</div>
</body>