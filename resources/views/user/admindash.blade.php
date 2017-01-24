@extends('layout.master')

@section('header')
    @include('layout.header')
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
                <li role="presentation"><a href="{{ route('signup') }}">Add Shopkeeper</a></li>
                <li role="presentation"><a href="{{ route('signup') }}">Add Customer</a></li>
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