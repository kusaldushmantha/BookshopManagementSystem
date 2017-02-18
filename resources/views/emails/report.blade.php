


<body>

        <div class="row">
            <div class="col-md-3">
                <label for="reportRequester">Requested By: {{ Auth::user()-> firstname.' '.Auth::user()->lastname }}</label>
                <br>
                <label>On: {{ $date }}</label>

            </div>
        </div>
        <br>
        <hr>
        <div class="row">
            <div>
                <label class=" col-md-8 reportTitle">Overall Report for TreeHouse Bookstore from {{ $prevMonthDate }} to {{ $date }}</label>
            </div>
            <br>
        </div>
        <hr>

        <div class="row">

        </div>

        <div class="panel panel-default col-md-6">
            <!-- Default panel contents -->
            <div class="panel-heading text-center"><strong>Books Sold Online</strong></div>

            <!-- Table -->
            <table>
            <thead>
            <tr>
                <th class="col-md-4 ">Book Title</th>
                <th class="col-md-1 text-center">Quantity Sold</th>
                <th class="col-md-2">Unit Price</th>
                <th class="col-md-2">Income</th>
            </tr>
            </thead>
            <tbody>

            @foreach (array_keys($bookArray) as $book)

            <tr>
                <td class="col-md-4 ">{{$book}}</td>
                <td class="col-md-1 text-center">{{$bookArray[$book][0]}}</td>
                <td class="col-md-1">${{$bookArray[$book][2]}}</td>
                <td class="col-md-2">${{$bookArray[$book][1]}}</td>

            </tr>

            @endforeach

            </tbody>
            </table>
            <div class="panel-footer text-center"><strong>Total Income : ${{ $totalIncome }}</strong></div>
        </div>
        <div class="row">

        </div>
        <div class="panel panel-default col-md-6">
            <!-- Default panel contents -->
            <div class="panel-heading text-center"><strong>Customer Subscription within this Time Period</strong></div>

            <!-- Table -->
            <table>
                <thead>
                <tr>
                    <th class="col-md-4 ">Subscribed Date</th>
                    <th class="col-md-1 text-center">Number of Subscriptions</th>
                </tr>
                </thead>
                <tbody>
                @php($count =0)
                @foreach ($subscribedUsers as $subscribedUser)

                    <tr>
                        <td class="col-md-4 ">{{ $subscribedUser->subscribed_on }}</td>
                        <td class="col-md-1 text-center">{{ $subscribedUser->total }}</td>
                        <div class="hidden" >@php($count = $count+$subscribedUser->total)</div>

                    </tr>

                @endforeach

                </tbody>
            </table>
            <div class="panel-footer text-center"><strong>Total Subscriptions : {{ $count }}</strong></div>
        </div>

        <div class="row">

        </div>

</body>
