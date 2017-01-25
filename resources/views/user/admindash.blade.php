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
            background-image: url('src/img/booklotreOp.jpg');
            background-repeat: repeat-y;
            background-size:1400px 725px;

        }
    </style>
@endsection

@section('body')
    <div class="row">
            <ul class="nav nav-pills navbarFonts">
                <li role="presentation" class="active"><a href="{{ route('admindash') }}">Book Store</a></li>
                <li role="presentation"><a href="{{ route('addbook') }}">Add Book</a></li>
                <li role="presentation"><a href="{{ route('signup') }}">Add Shopkeeper/Customer</a></li>
                <li role="presentation"><a href="{{ route('signup') }}">View Store Status</a></li>
            </ul>
    </div>
    <div>
        <br>

        @foreach($books->chunk(3) as $bookChunks)
            <div class="row ">
                @foreach($bookChunks as $bookChunk)
                    <div class="col-sm-4 viewManager">
                        <div class="thumbnail">
                            <img src="{{ $bookChunk->image_path }}"
                                 alt="..."class="img-responsive">
                            <div class="caption">
                                <div class="booktitle">{{ $bookChunk->title }}</div>
                                <div class="pull-left author">{{ $bookChunk->author }}</div>
                                <br>
                                <div class="clearfix">
                                    <div class="pull-left price">${{ $bookChunk->price }}</div>
                                    @if(!$bookChunk->quantity==0)
                                        <a href="#" class="btn btn-success pull-right buybook"
                                           role="button">Get Book</a>
                                    @else
                                        <a class="btn btn-danger pull-right notAvailable"
                                           role="button" disabled="">Not Available</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection