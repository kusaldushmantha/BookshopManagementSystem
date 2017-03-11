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

    @if(Session::has('shippedsuccess'))
        <script type="text/javascript">
            swal("Shipped Successfull !", "Books successfully Shipped.", "success")
        </script>
    @endif

    @if(Session::has('deletesuccess'))
        <script type="text/javascript">
            swal("Delete Successfull !", "Order details successfully Deleted.", "success")
        </script>
    @endif

    <div class="panel panel-default panelBorder2">
        <div class="panel-heading ordersCustomer"><strong>Orders Placed By Customers</strong></div>
        <table class="table">
            <thead>
            <tr>
                <th>#Order id</th>
                <th>Customer Name</th>
                <th>Shipping Address</th>
                <th>Cart Details</th>
                <th>Ordered Date</th>
                <th>Order Status</th>
            </tr>
            </thead>
            <tbody>

            @foreach($orderDetails as $od)
                @php($cartDetails = DB::table('adminorders')->where(['order_id'=>$od->order_id])->first())
                <tr>
                    <td class="col-md-1">{{$cartDetails->id}}</td>
                    <td class="col-md-2">{{$cartDetails->customername}}</td>
                    <td class="col-md-4">{{$cartDetails->address}}</td>
                    @php($cart = unserialize($cartDetails->cart))

                    <td class="col-md-4">
                    @foreach($cart->books as $book)
                        {{$book['book']['title']}} - {{$book['qty']}}
                        <br>
                    @endforeach
                    </td>
                    <td class="col-md-3 col-md-offset-3">{{$cartDetails->updated_at}}</td>
                    <td class="col-md-1">
                    @if($od->order_status=='Ready')
                            <a type="button" class="btn btn-success shipthis" href="{{route('adminshiporder',['id'=>$od->order_id])}}">Ship Order</a>
                    @elseif($od->order_status=='Confirmed')
                            <a class="btn btn-success" disabled>Recieval Confirmed </a>
                            <a class="btn btn-danger deletethis" href="{{ route('deleteadminorder',['id'=>$od->order_id]) }}" >Delete Order</a>
                        @else
                        <a class="btn btn-info " disabled>Pending Confirmation</a><a class="btn btn-danger deletethis" href="{{ route('deleteadminorder',['id'=>$od->order_id]) }}">Delete Order</a>
                    @endif
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::to('src/js/sweetalert.min.js') }}"></script>
    <script type="text/javascript">
        $('.shipthis').click(function (e) {
            var href = $(this).attr('href');
            swal({
                        title: "Ship Order !",
                        text: "Are you sure You want to Ship this Order ?",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#62c462",
                        confirmButtonText: "Ship Order",
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
        $('.deletethis').click(function (e) {
            var href = $(this).attr('href');
            swal({
                        title: "Delete Order !",
                        text: "Are you sure You want to Delete this Order ?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Delete Order",
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

@endsection