@extends('layout.master')

@section('header')
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('admindash') }}"><i class="fa fa-home" aria-hidden="true">

                    </i> TreeHouse Books</a>
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
        <ul class="nav nav-pills navbarFonts">
            <li role="presentation"><a href="{{ route('viewstore') }}">All Store</a></li>
            <li role="presentation"><a href="{{ route('runningoutstocks') }}">Stocks Running Out</a></li>
            <li role="presentation"class="active"><a href="{{ route('emptystock') }}">Empty Stocks</a></li>
        </ul>
    </div>
    <br>
    <div class="row">
        @if($books->count()==0)
        <div class="col-md-4 col-md-offset-4 adddone">
                <div class="row">
                    <div id="message" class="alert alert-success">
                        <strong>Book Store Status is Satisfiable</strong>
                    </div>
                </div>
        </div>
        @else
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
                                        <a href="{{ route('updatebook',['id'=>$item->id]) }}"><button class="fa fa-pencil btn-success" aria-hidden="true"></button></a>
                                        <a class="delete_book" href="{{ route('deletebook',['id'=>$item->id]) }}"><button class="fa fa-trash modify btn-danger " aria-hidden="true"></button></a>
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

                @endif
    </div>
    </div>

@endsection

@section("scripts")

    <script src="{{ URL::to('src/js/sweetalert.min.js') }}"></script>
    <script type="text/javascript">
        $('.delete_book').click(function (e) {
            var href = $(this).attr('href');
            swal({
                        title: "Remove Book ?",
                        text: "You are about to remove the selected book.This action cannot be reversed.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Remove Book",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location.href = href;
                        }
                    });

            return false;
        });
    </script>


    <script type="text/javascript">
        window.setTimeout(function() {
            $("#charge-message").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 3000);
    </script>
@endsection
