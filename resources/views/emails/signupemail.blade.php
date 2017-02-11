@extends('layout.master')

<body>
    <div class="emailtitle">
        <strong>TreeHouse Books</strong>
    </div>
    <div class="container emailbody">
        @if($user->accesslevel=='customer')
            <p><br>Hello {{$user->username}}!
                <br><br>
                Since you're a new customer, we want to make sure you have all the information you need.
                <br><br>
                To start browsing our store please visit <a href="http://localhost:8000/signup">http://localhost:8000/signin</a>.
                <br>
                Please do not hesitate to contact us if you need any assistance with our system.
                <br><br>
                Happy Reading.. !!!
                <br><br>
                Sincerely,
                <br>
                TreeHouse People :)
            </p>
        @else
            <p><br>Hello {{$user->username}}!
                <br><br>
                Since you're a new Staffmember, we want to make sure you have all the information you need.
                <br><br>
                To start browsing our store please visit <a href="http://localhost:8000/signup">http://localhost:8000/signin</a>.
                <br>
                Please do not hesitate to contact us if you need any assistance with our system.
                <br><br>
                Happy Working.. !!!
                <br><br>
                Sincerely,
                <br>
                TreeHouse People :)
            </p>
        @endif
    </div>
</body>