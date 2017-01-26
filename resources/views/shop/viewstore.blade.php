@extends('layout.master')

@section('header')
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('admindash') }}"><i class="fa fa-home" aria-hidden="true">

                    </i> TreeHouse Books</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            Shopping Cart</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"
                                                                         aria-hidden="true"></i>
                            My Account<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Change Account</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('logout') }}">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endsection

@section('styles')
    <style>
        body{
            background-image: url('src/img/bookstorereOp.jpg');
            background-repeat: repeat-y;
            background-size:1400px 725px;

        }
    </style>
@endsection

@section('body')
    <div class="row">
        <div class="col-md-4 col-md-offset-4 adddone">
            @if(Session::has('success'))
                <div class="row">
                    <div id="charge-message" class="alert alert-success">
                        <strong>{{ Session::get('success') }}</strong>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-8 col-md-offset-2">

            @foreach(array_chunk($books->getCollection()->all(),20) as $bookChunks)
                <div class="panel panel-default panelBorder">
                    <div class="panel-body">
                        <ul class="list-group panelBorder">
                            @foreach($bookChunks as $item)
                                <li class="list-group-item">
                                    {{ $item['title'] }}
                                    @if($item['quantity']==0)
                                        <span class="badge badgeqtyalert"> {{ $item['quantity'] }} Units </span>
                                    @else
                                        <span class="badge badgeqtyok"> {{ $item['quantity'] }} Units </span>
                                    @endif
                                    <span class="badge alignauthor"> {{ $item['author'] }} </span>
                                    <span class="badge alignprice"> ${{ $item['price'] }} </span>
                                    <span class="btn-group btnmodify">
                                        <a href="{{ route('updatebook',['id'=>$item->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a href="#"><i class="fa fa-trash modify" aria-hidden="true"></i></a>
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach

            <div class="storeViewPaginateAlign">
                {{ $books->links() }}
            </div>

        </div>
    </div>
@endsection