@extends('layout.master')

@section('header')
    @include('layout.header')
@endsection

@section('styles')
    <style>
        body{
            background-image: url('src/img/blankBookreOp.jpg');
            background-repeat: no-repeat;
            background-size:1400px 650px;

        }
    </style>
@endsection

@section('body')

    <div class="row addbookrow">
        <div class="addbookcontainer">
            <form action="#" method="post" id="addBookForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title" class="addbooklabel">Book Title :</label>
                    <input type="text" name="title" id="title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="author" class="addbooklabel">Author :</label>
                    <input type="text" name="author" id="author" class="form-control">
                </div>
                <div class="form-group">
                    <label for="quantity" class="addbooklabel">Quantity :</label>
                    <input type="number" name="qty" id="qty" class="form-control">
                </div>
                <div class="form-group">
                            <label for="image" class="addbooklabel">Cover Image :</label>
                            <input type="file" name="image" id="image" class="form-control">
                            <br>
                        </div>
                        <div class="form-group ">
                            <button type="submit" name="submit" class="btn btn-success addBookBtn">Add Book</button>
                        </div>
                {{csrf_field()}}
                    </form>
                </div>
            </div>
    </div>



@endsection