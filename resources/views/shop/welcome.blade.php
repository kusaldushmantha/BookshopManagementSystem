@extends('layout.master')

@section('styles')
    <style>
        body{
            background-image: url('src/img/openBookreOp.jpg');
            background-repeat: no-repeat;
            background-size:1400px 650px;
            background-opacity:0.5;
        }
    </style>
@endsection

@section('body')
    <div class="titleContainer">
        <h2 class="welcomeTitle">Welcome !!!</h2>
        <h2 class="welcomeTitle">The TreeHouse Books</h2>
    </div>

    <div class="row signIn">
        <div class="col-md-4 col-md-offset-4">
            <form action="#" method="post" id="loginForm">
                <div class="form-group">
                    <label for="username" class="loginLabels">Username : </label>
                    <input type="text" id="username" name="username" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password" class="loginLabels">Password :</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <div class="buttonalign">
                    <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
                {{ csrf_field() }}
            </form>
            <p>  </p>
            <p id="loginP">
                Don't have an Account Yet?
            </p>
            <div class="loginAlternative">
                <a href="#" class="createAccountLogin">Create an Account </a>
                &nbsp;&nbsp;
                <a href="#" class="createAccountLogin">Browse Books only</a>
            </div>
        </div>
    </div>
@endsection