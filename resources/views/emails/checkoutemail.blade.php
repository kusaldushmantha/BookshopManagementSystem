@extends('layout.master')

<body>
<div class="emailtitle">
    <strong>TreeHouse Books</strong>
</div>
<div class="container emailbody">
        <p><br>Hello {{$user->username}}!
            <br><br>
            Your have successfully purchased the following order
            <br><br>
        <div class="panel panel-success panelModify">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Purchases on : {{$purchase->updated_at}}</strong></h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    @foreach($purchase->cart->books as $book)
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
            <div class="panel-footer"><strong>Total Price : ${{ $purchase->cart->totalPrice }}</strong></div>
        <hr>
        <br>
        Your Order Recieved and will be Delivered to the following Address :
        <br><br>
        <strong>{{ $details->customername }}</strong>
        <br>
        <strong>{{ $details->address }}</strong>
        <br>
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