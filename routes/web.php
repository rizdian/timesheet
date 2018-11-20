<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

//Division
Route::resource('division', 'DivisionController', [
    'except' => ['create', 'show']
]);
Route::get('data/division', 'DivisionController@getData')->name('data.division');

//Division
Route::resource('incentive', 'IncentiveController', [
    'except' => ['create', 'show']
]);
Route::get('data/incentive', 'IncentiveController@getData')->name('data.incentive');
