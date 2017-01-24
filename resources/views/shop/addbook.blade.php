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

            <form action="{{ route('postaddbook') }}" method="post" id="addBookForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title" class="addbooklabel">Book Title :</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="author" class="addbooklabel">Author :</label>
                    <input type="text" name="author" id="author" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="price" class="addbooklabel">Unit Price :</label>
                    <input type="string" name="price" id="price" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="quantity" class="addbooklabel">Quantity :</label>
                    <input type="string" name="qty" id="qty" class="form-control" required>
                </div>
                <div class="form-group">
                            <label for="image" class="addbooklabel">Cover Image :</label>
                            <input type="file" name="image" id="image" class="form-control" required>
                            <br>
                    <label for="imageWarning"> **It is recomended to place all images in the same location</label>
                </div>
                <div class="form-group ">
                    <button type="submit" name="submit" class="btn btn-success addBookBtn"
                    onclick = "validateLetters(author,'Author'),validateFloat(price,'Price'),
                    validateNumbers(qty,'Quantity')">Add Book</button>
                </div>
                {{csrf_field()}}
            </form>
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
        function validateFloat(inputnum,inputString){
            if(inputnum.value==''){

            }else if (isNaN(inputnum.value)) {
                alert("Please Enter Valid Price For : "+inputString);
                inputnum.value='';
            }else if(inputnum.value<=0){
                alert("Please Enter Valid Price For : "+inputString);
                inputnum.value='';
            }else{
                return true;
            }
        }
        function validateLetters(inputnum,inputString) {
            var letters = /^[A-Za-z\s\.]+$/;
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

            }else if(username.match(/[^0-9a-z\.\s]/i)) {
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