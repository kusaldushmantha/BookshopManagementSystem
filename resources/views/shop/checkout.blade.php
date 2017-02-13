@extends('layout.master')

@section('header')
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('customerdash') }}"><i class="fa fa-home" aria-hidden="true"></i> TreeHouse Books</a>
            </div>
        </div>
    </nav>
@endsection

@section('styles')
    <style>
        body{
            background-image: url('src/img/bookstackreOp.jpg');
            background-repeat: repeat-y;
            background-size:1400px 1000px;
        }
    </style>
@endsection

@section('body')
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
            <h1 class="check"><strong>Checkout</strong></h1>
            <h4 class="check">Your Total is : ${{$total}}</h4>
            <hr>
            <div id="charge-error" class="alert alert-danger {{ !Session::has('error')? 'hidden':''}}">
                {{ Session::get('error') }}
            </div>
            <form action="{{ route('checkout') }}" method="post" id="checkoutform">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="name">Cutomer Name: </label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="name">Shipping Address: </label>
                            <input type="text" id="address" name="address" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="name">Credit Card Number: </label>
                            <input type="text" id="cardno"  class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="name">Expiry Month: </label>
                            <input type="text" id="expmonth" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="name">Expiry Year: </label>
                            <input type="text" id="expyear" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="name">CVC: </label>
                            <input type="text" id="cvc" class="form-control" required>
                        </div>
                    </div>
                </div>
                <br>
                {{ csrf_field() }}
                <button type="submit" id="checkoutButton" class="btn btn-success buy">Buy Books</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript" src="{{ URL::to('src/js/checkout.js') }}"></script>
    <script type="text/javascript">
        window.setTimeout(function() {
            $("#charge-error").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 3000);
    </script>
@endsection