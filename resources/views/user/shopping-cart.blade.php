@extends('layout.master')

@section('header')
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                @if(Auth::user()->accesslevel=="customer"))
                    <a class="navbar-brand" href="{{ route('customerdash') }}"><i class="fa fa-home" aria-hidden="true"></i> TreeHouse Books</a>
                @else
                    <a class="navbar-brand" href="{{ route('admindash') }}"><i class="fa fa-home" aria-hidden="true"></i> TreeHouse Books</a>
                @endif
            </div>
        </div>
    </nav>
@endsection

@section('styles')
    <style>
        body{
            background-image: url('src/img/buybook2reOp.jpg');
            background-repeat: repeat-y;
            background-size:1400px 1000px;
        }
    </style>
@endsection

@section('body')

    @if(Session::has('cart'))
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-6">
                <ul class="list-group">
                    @foreach($books as $book)
                        <li class="list-group-item">
                            <label class=" badgeqty"> {{$book['qty']}} </label>
                            <strong>{{$book['book']['title']}}</strong>
                            <h4><span style="position: absolute;top: 20%;right: 25px" class="label label-success">
                                        ${{$book['price']}}</span></h4>
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger btn-xs dropdown-toggle"
                                        data-toggle="dropdown">Remove Item <span class="caret">
                                        </span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('reduceByOne',['id'=>$book['book']['id']]) }}">Remove One</a></li>
                                    <li><a href="{{ route('removeall',['id'=>$book['book']['id']]) }}">Remove All</a></li>
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <strong class="total">Total : ${{$totalPrice}}</strong>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <a href="{{ route('checkout') }}" type="button" class="btn btn-success pull-right "><strong>Checkout</strong></a>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3 alert alert-danger adddone">
                <h2>Your Cart is Empty</h2>
                <strong>Please add books to cart to continue</strong>
            </div>
        </div>
    @endif
@endsection