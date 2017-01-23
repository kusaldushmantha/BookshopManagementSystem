@extends('layout.master')

@section('header')

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-home" aria-hidden="true"></i> TreeHouse Books</a>
            </div>
        </div>
    </nav>

@endsection

@section('styles')
    <style>
        body{
            background-image: url('src/img/bookstackreOp.jpg');
            background-repeat: no-repeat;
            background-size:1400px 650px;
            background-opacity:0.5;
        }
    </style>
@endsection

@section('body')
    <div class="container ">
    <div class="row" >
        <div class="signupcontainer">
            <form action="#" method="post" id="signinForm">
                <div class="form-group">
                    <label for="Firstname" class="labelFonts">Firstname : </label>
                    <input type="text" name="firstname" id="firstname" class="form-control">
                </div>
                <div class="form-group">
                    <label for="Lastname" class="labelFonts">Lastname : </label>
                    <input type="text" name="lastname" id="lastname" class="form-control">
                </div>
                <div class="form-group">
                    <label for="Username" class="labelFonts">Username : </label>
                    <input type="text" name="username" id="username" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password" class="labelFonts">Password :</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password" class="labelFonts">Confirm Password :</label>
                    <input type="password" name="confirmpassword" id="confirmpassword" class="form-control">
                </div>
                <div class="form-group">
                    <label for="contactNo" class="labelFonts">Contact No :</label>
                    <input type="text" name="contactno" id="contactno" class="form-control">
                </div>
                <div class="form-group">
                    <label for="accesslevel" class="labelFonts">Access Level :</label>
                    &nbsp;&nbsp;
                    <input  class="labelFonts" type="radio" name="accesslevel" id="customeraccess" value="customer" checked>
                    <strong>Customer</strong>
                    &nbsp;&nbsp;&nbsp;
                    <input class="labelFonts" type="radio" name="accesslevel" id="adminaccess" value="admin">
                    <strong>Administrator</strong>
                </div>
                <div class="clearfix" class="labelFonts">
                    <button type="submit" class="btn btn-success signupbtn">Create Account</button>
                </div>
                {{csrf_field()}}
            </form>
        </div>
    </div>
    </div>

@endsection


