@extends('layout.master')

@section('styles')
    <style>
        body{
            background-image: url('src/img/openBookreOp.jpg');
            background-repeat: no-repeat;
            background-size:1400px 750px;
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

            @if(Session::has('customersuccess'))
                <script type="text/javascript">
                    swal("Success!", "Account Successfully Created ! Please sign-in to continue", "success")
                </script>
            @endif

            @if(count($errors)>0)
                    <script type="text/javascript">
                        swal({
                                    title: "Invalid Entry !",
                                    text: "Username / Password you entered is invalid",
                                    type: "error",
                                    showCancelButton: false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "OK",
                                    closeOnConfirm: false
                                });
                    </script>
            @endif

            <form action="{{ route('postsignin') }}" method="post" id="loginForm">
                <div class="form-group">
                    <label for="username" class="loginLabels">Username : </label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password" class="loginLabels">Password :</label>
                    <input type="password" id="password" name="password" class="form-control" required>
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
                <a href="{{ route('signup') }}" class="createAccountLogin">Create an Account </a>
                &nbsp;&nbsp;
                <a href="{{ route('customerdash') }}" class="createAccountLogin">Browse Books only</a>
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
        }, 3000);
    </script>
@endsection