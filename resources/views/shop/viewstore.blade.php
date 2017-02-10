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
            <li role="presentation" class="active"><a href="{{ route('viewstore') }}">All Store</a></li>
            <li role="presentation"><a href="{{ route('runningoutstocks') }}">Stocks Running Out</a></li>
            <li role="presentation"><a href="{{ route('emptystock') }}">Empty Stocks</a></li>
        </ul>
    </div>
    <br>
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

        @if(Session::has('updatebooksuccess'))
            <script type="text/javascript">
                swal("Update Successfull !", "Book Successfully Updated", "success")
            </script>
        @endif

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

        </div>
    </div>
@endsection

@section("scripts")
        <script type="text/javascript">
            window.setTimeout(function() {
                $("#charge-message").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                });
            }, 3000);
        </script>
@endsection
