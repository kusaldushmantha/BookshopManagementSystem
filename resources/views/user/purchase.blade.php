@extends('layout.master')

@section('header')
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                @if(Auth::user()->accesslevel == "customer")
                    <a class="navbar-brand" href="{{ route('customerdash') }}"><i class="fa fa-home" aria-hidden="true"></i> TreeHouse Books</a>
                @elseif(Auth::user()->accesslevel == "admin")
                    <a class="navbar-brand" href="{{ route('admindash') }}"><i class="fa fa-home" aria-hidden="true"></i> TreeHouse Books</a>
                @else
                    <a class="navbar-brand" href="{{ route('signin') }}"><i class="fa fa-home" aria-hidden="true"></i> TreeHouse Books</a>

                @endif
            </div>
        </div>
    </nav>
@endsection

@section('styles')
    <style>
        body{
            background-image: url('src/img/booksreOp.jpg');
            background-repeat: repeat-y;
            background-size:1400px 750px;
        }
    </style>
@endsection

@section('body')
    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <h2 align="center">My Purchases</h2>
            <hr>
            <br>
            @if($purchase->count()==0)
                <div class="col-md-4 col-md-offset-4 adddone">
                    <div class="row">
                        <div id="message" class="alert alert-success">
                            <strong>Empty Purchase History</strong>
                        </div>
                    </div>
                </div>
            @else
            @foreach($purchase as $p)
                <div class="panel panel-success panelModify">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Purchases on : {{$p->updated_at}}</strong></h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach($p->cart->books as $book)
                                <li class="list-group-item">
                                    <span class="badge">${{ $book['price'] }}</span>
                                    <span class="badge badgePurchaseSuccess">{{ $book['qty'] }}</span>
                                    <strong>{{ $book['book']['title'] }}</strong>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="panel-footer"><strong>Total Price : ${{ $p->cart->totalPrice }}</strong></div>
                </div>
            @endforeach
            @endif
        </div>
    </div>
@endsection