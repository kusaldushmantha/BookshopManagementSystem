@extends('layout.master')

@section('header')
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                @if(Auth::user())
                    @if(Auth::user()->accesslevel == "customer")
                        <a class="navbar-brand" href="{{ route('customerdash') }}"><i class="fa fa-home" aria-hidden="true"></i> TreeHouse Books</a>
                    @else
                        <a class="navbar-brand" href="{{ route('signin') }}"><i class="fa fa-home" aria-hidden="true"></i> TreeHouse Books</a>
                    @endif
                @else
                    <a class="navbar-brand" href="{{ route('signin') }}"><i class="fa fa-home" aria-hidden="true"></i> TreeHouse Books</a>
                        <ul class="nav navbar-nav navbar-right">
                            <form action="{{ route('searchbook') }}" class="navbar-form navbar-left">
                                <div class="form-group">
                                    <input type="text" id="search " name="search" class="form-control" placeholder="Enter Book Title or Author">
                                </div>
                                <button type="submit" class="btn btn-default">Search</button>
                                {{csrf_field()}}
                            </form>
                        </ul>
                @endif
            </div>
            @if(Auth::user())
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <form action="{{ route('searchbook') }}" class="navbar-form navbar-left">
                        <div class="form-group">
                            <input type="text" id="search " name="search" class="form-control" placeholder="Enter Book Title or Author">
                        </div>
                        <button type="submit" class="btn btn-default">Search</button>
                        {{csrf_field()}}
                    </form>
                    <li><a href="{{ route('shoppingcart') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            Shopping Cart  <span class="badge">{{Session::has('cart') ?
                            Session::get('cart')->totalQty :''}}</span>
                        </a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i>
                            My Account<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('updateaccount',['id'=>Auth::user()->id]) }}">Change Account</a></li>
                            <li><a href="{{ route('getmypurchase',['id'=>Auth::user()->id]) }}">My Purchases</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('logout') }}">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            @endif
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
    @if(Session::has('success'))
        <div class="row adddone">
            <div id="charge-message" class="alert alert-success">
                <strong>{{ Session::get('success') }}</strong>
            </div>
        </div>
    @endif

    @if(Session::has('customerpurchasesuccess'))
        <script type="text/javascript">
            swal("Purchase Successfull !", "Books successfully purchased. Thank you !", "success")
        </script>
    @endif

    @if(Session::has('customerupdatesuccess'))
        <script type="text/javascript">
            swal("Update Successfull !", "Your Account Updated Successfully", "success")
        </script>
    @endif

    @if(Session::has('updatedanger'))
        <script type="text/javascript">
            swal("Error in Update !", "Entered Old Password Does not match with Current Password", "error")
        </script>
    @endif

    @if(Session::has('noresult'))
        <script type="text/javascript">
            swal("No Books Found !!!", "Unfortunately your Search returned no Books. Try altering the search or Browse for other Books", "info")
        </script>
    @endif


    @foreach(array_chunk($books->getCollection()->all(),3) as $bookChunks)
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
                                    @if(Auth::user())
                                        <a href="{{ route('addtocart',['id'=>$bookChunk->id]) }}"
                                           class="btn btn-success pull-right buybook" role="button">Get Book</a>
                                    @else
                                        <button class="btn buybook btn-success pull-right" disabled>Available</button>
                                    @endif
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
    <div class="paginateAlign">
        {{ $books->links() }}
    </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        window.setTimeout(function() {
            $("#charge-message").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 3000);
    </script>
@endsection