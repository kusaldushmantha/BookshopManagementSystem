@extends('layout.master')

@section('header')

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                @if(Auth::user()->accesslevel=="admin")
                    <a class="navbar-brand" href="{{ route('admindash') }}"><i class="fa fa-home" aria-hidden="true">
                        </i> TreeHouse Books</a>
                @else
                    <a class="navbar-brand" href="{{ route('customerdash') }}"><i class="fa fa-home" aria-hidden="true">
                        </i> TreeHouse Books</a>
                @endif
            </div>
        </div>
    </nav>

@endsection

@section('styles')
    <style>
        body{
            background-image: url('src/img/openBookreOp.jpg');
            background-repeat: no-repeat;
            background-size:1400px 1000px;
        }
    </style>
@endsection

@section('body')
    <div class="container ">
        <div class="row" >
            <div class="signupcontainer">

                @if(count($errors)>0)
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $recievedError)
                            <p>{{$recievedError}}</p>
                        @endforeach
                    </div>
                @endif

                    @if(Session::has('success'))
                        <div class="row adddone">
                            <div id="charge-message" class="alert alert-success">
                                <strong>{{ Session::get('success') }}</strong>
                            </div>
                        </div>
                    @endif

                    @if(Session::has('danger'))
                        <div class="row adddone">
                            <div id="charge-message" class="alert alert-danger">
                                <strong>{{ Session::get('danger') }}</strong>
                            </div>
                        </div>
                    @endif

                    @if(Session::has('updatedanger'))
                        <div class="row adddone">
                            <div id="charge-message" class="alert alert-danger">
                                <strong>{{ Session::get('updatedanger')}}</strong>
                            </div>
                        </div>
                    @endif

                <form action="{{ route('postupdateaccount') }}" method="post" id="signupForm" name="signupForm">
                    <div class="form-group">
                        <label for="Firstname" class="labelFonts">Firstname : </label>
                        <input type="text" name="firstname" id="firstname" class="form-control" value="{{ $user->firstname}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="Lastname" class="labelFonts">Lastname : </label>
                        <input type="text" name="lastname" id="lastname" class="form-control" value="{{ $user->lastname}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="Username" class="labelFonts">New Username : </label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="labelFonts">Old Password :</label>
                        <input type="password" name="oldpassword" id="oldpassword" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="labelFonts">New Password :</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="labelFonts">Confirm New Password :</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="labelFonts">Email :</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" class="form-control" value="{{ $user->id }}" hidden>
                    </div>
                    <div class="clearfix" class="labelFonts">
                        <button type="submit" class="btn btn-success signupbtn" id="btnSubmit"
                                onclick="validateLetters(firstname,'Firstname'),
                    validateLetters(lastname,'Lastname'),
                    validateSpecialCharacters(username,'Username'),
                    validateSpecialCharacters(password,'Password')">
                            Update Account</button>
                    </div>
                    {{csrf_field()}}
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
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

@section('scripts')
    <script type="text/javascript">
        window.setTimeout(function() {
            $("#charge-message").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 3000);
    </script>
@endsection
