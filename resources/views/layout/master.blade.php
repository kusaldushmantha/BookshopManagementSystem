<!doctype html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title')
    </title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">
    <script src="https://use.fontawesome.com/d42c93a016.js"></script>
    <script src="src/js/sweetalert.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('src/css/sweetalert.css')}}">
    <link rel="stylesheet" href="{{URL::to('src/css/app.css')}}">



</head>

<body>
    @yield('header')

    @yield('styles')

    <div class="container">
        @yield('body')
    </div>

    <script
            src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
            crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

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


    @yield('scripts')

</body>

</html>