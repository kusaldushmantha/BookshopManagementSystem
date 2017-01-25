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