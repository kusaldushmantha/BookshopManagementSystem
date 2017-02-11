@extends('layout.master')

@section('header')

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                @if(Auth::user())
                    <a class="navbar-brand" href="{{ route('admindash') }}"><i class="fa fa-home" aria-hidden="true">
                        </i> TreeHouse Books</a>
                @else
                    <a class="navbar-brand" href="{{ route('signin') }}"><i class="fa fa-home" aria-hidden="true">
                        </i> TreeHouse Books</a>
                @endif
            </div>
        </div>
    </nav>

@endsection

@section('styles')
    <style>
        body{
            background-image: url('src/img/bookstackreOp.jpg');
            background-repeat: no-repeat;
            background-size:1400px 1000px;
            background-opacity:0.5;
        }
    </style>
@endsection

@section('body')
    <div class="container ">
    <div class="row" >
        <div class="signupcontainer">

            @if(count($errors)>0)
                <div id="charge-message" class="alert alert-danger">
                    @foreach($errors->all() as $recievedError)
                        <p><strong>{{$recievedError}}</strong></p>
                    @endforeach
                </div>

            @endif

            <form action="{{ route('postsignup') }}" method="post" id="signupForm" name="signupForm">
                <div class="form-group">
                    <label for="Firstname" class="labelFonts">Firstname : </label>
                    <input type="text" name="firstname" id="firstname" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="Lastname" class="labelFonts">Lastname : </label>
                    <input type="text" name="lastname" id="lastname" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="Username" class="labelFonts">Username : </label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password" class="labelFonts">Password :</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password" class="labelFonts">Confirm Password :</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email" class="labelFonts">Email :</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="accesslevel" class="labelFonts">Access Level :</label>
                    &nbsp;&nbsp;
                    <input  class="labelFonts" type="radio" name="accesslevel" value="customer" checked>
                    <strong>Customer</strong>
                    &nbsp;&nbsp;&nbsp;
                    @if(Auth::user())
                        <input class="labelFonts" type="radio" name="accesslevel" value="admin">
                        <strong>Administrator</strong>
                    @endif
                </div>
                <div class="clearfix" class="labelFonts">
                    <button type="submit" class="btn btn-success signupbtn" id="btnSubmit"
                    onclick="validateNumbers(contactno,'ContactNo'),validateLetters(firstname,'Firstname'),
                    validateLetters(lastname,'Lastname'),
                    validateSpecialCharacters(username,'Username'),
                    validateSpecialCharacters(password,'Password')">
                        Create Account</button>
                </div>
                {{csrf_field()}}
            </form>
        </div>
    </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript">
        window.setTimeout(function() {
            $("#charge-message").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 10000);
    </script>

     <script type="text/javascript">
        function validateNumbers(inputnum,inputString) {
            var num = /^[0-9]+$/;
            if(inputnum.value==''){

            }else if(inputnum.value.match(num)) {
                return true;
            }else{
                alert("Please Enter Only Numeric Characters For : "+inputString);
                inputnum.value='';
                return false;
            }
        }
        function validateLetters(inputnum,inputString) {
            var letters = /^[A-Za-z\s]+$/;
            if(inputnum.value==''){

            }else if (inputnum.value.match(letters)){
                validateSpecialCharacters(inputnum,inputString)
                return true;
            }else{
                alert("Please Enter Alphabetic Characters Only For : "+inputString);
                inputnum.value='';
                return false;
            }
        }
        function validateSpecialCharacters(inputnum,inputString) {
            var username = inputnum.value;
            if(inputnum.value==''){

            }else if(username.match(/[^0-9a-z]/i)) {
                alert("Only letters and digits allowed in "+inputString);
                inputnum.value='';
                return false;
            }else if(!username.match(/[a-z]/i)) {
                alert("At least one letter required in "+inputString);
                inputnum.value='';
                return false;
            }
            return true;
        }
    </script>
@endsection
