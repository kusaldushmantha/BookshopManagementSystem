<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/signin', [
    'uses'=>'UserController@getSignin',
    'as'=>'signin'
]);

Route::get('/signup',[
    'uses'=>'UserController@getSignup',
    'as'=>'signup'
]);

Route::post('/signup',[
    'uses'=>'UserController@postSignup',
    'as'=>'postsignup'
]);

Route::post('/signin',[
    'uses'=>'UserController@postSignin',
    'as'=>'postsignin'
]);

Route::get('/addbook',[
    'uses'=>'ShopController@getAddBook',
    'as'=>'addbook',
    'middleware'=>'auth'
]);


Route::get('/updatebook/{id}',[
    'uses'=>'ShopController@getUpdateBook',
    'as'=>'updatebook',
    'middleware'=>'auth'
]);

Route::post('/updatebook',[
    'uses'=>'ShopController@postUpdateBook',
    'as'=>'postupdatebook',
    'middleware'=>'auth'
]);

Route::get('/deletebook/{id}',[
    'uses'=>'ShopController@getDeleteBook',
    'as'=>'deletebook',
    'middleware'=>'auth'
]);

Route::post('/addbook',[
    'uses'=>'ShopController@postAddBook',
    'as'=>'postaddbook',
    'middleware'=>'auth'
]);

Route::get('/admindash',[
    'uses'=>'ShopController@getAdmindash',
    'as'=>'admindash',
    'middleware'=>'auth'
]);

Route::get('/logout',[
    'uses'=>'UserController@getLogout',
    'as'=>'logout',
    'middleware'=>'auth'
]);

Route::get('/viewstore',[
    'uses'=>'ShopController@getViewStore',
    'as'=>'viewstore',
    'middleware'=>'auth'
]);

Route::get('/emptystocks',[
    'uses'=>'ShopController@getEmptyStocks',
    'as'=>'emptystock',
    'middleware'=>'auth'
]);

Route::get('/runningoutstocks',[
    'uses'=>'ShopController@getRunningOutStocks',
    'as'=>'runningoutstocks',
    'middleware'=>'auth'
]);

Route::get('/customerdash',[
    'uses'=>'UserController@getCustomerDash',
    'as'=>'customerdash',
    'middleware'=>'auth'
]);

Route::get('/shoppingcart',[
    'uses'=>'ShopController@getShoppingCart',
    'as'=>'shoppingcart',
    'middleware'=>'auth'
]);

Route::get('/addtocart/{id}',[
    'uses'=>'ShopController@getAddtoCart',
    'as'=>'addtocart',
    'middleware'=>'auth'
]);

Route::get('/reduce/{id}',[
    'uses'=>'ShopController@getReduceByOne',
    'as'=>'reduceByOne',
    'middleware'=>'auth'
]);

Route::get('/remove/{id}',[
    'uses'=>'ShopController@getReduceAll',
    'as'=>'removeall',
    'middleware'=>'auth'
]);

Route::get('/updateaccount/{id}',[
    'uses'=>'UserController@getUpdateAccount',
    'as'=>'updateaccount',
    'middleware'=>'auth'
]);

Route::post('/updateaccount',[
    'uses'=>'UserController@postUpdateAccount',
    'as'=>'postupdateaccount',
    'middleware'=>'auth'
]);

Route::get('/checkout',[
   'uses'=>'ShopController@getCheckout',
    'as'=>'checkout'
]);

Route::post('/checkout',[
    'uses'=>'ShopController@postCheckout',
    'as'=>'checkout'
]);

Route::get('/mypurchase',[
    'uses'=>'UserController@getMyPurchase',
    'as'=>'getmypurchase',
    'middleware'=>'auth'
]);

Route::post('/mypurchase',[
    'uses'=>'UserController@postmypurchase',
    'as'=>'postmypurchase',
    'middleware'=>'auth'
]);

Route::get('/signupemail',[
    'uses'=>'UserController@getsignupemail',
    'as'=>'signupemail'
]);

Route::get('/vieworders',[
    'uses'=>'UserController@getViewOrders',
    'as'=>'vieworders',
    'middleware'=>'auth'
]);

Route::get('/shiporder/{id}',[
    'uses'=>'UserController@getShipOrder',
    'as'=>'adminshiporder',
    'middleware'=>'auth'
]);

Route::get('/confirmOrder/{id}',[
    'uses'=>'UserController@getConfirmationOnRecieved',
    'as'=>'confirmrecieve',
    'middleware'=>'auth'
]);

Route::get('/deleteThisPurchase/{id}',[
    'uses'=>'UserController@getDeleteThisPurchase',
    'as'=>'deleteThisPurchase',
    'middleware'=> 'auth'
]);

Route::get('/deleteAdminOrder/{id}',[
    'uses'=>'UserController@getDeleteAdminOrder',
    'as'=>'deleteadminorder',
    'middleware'=>'auth'
]);