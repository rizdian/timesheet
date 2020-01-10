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

Route::group(['middleware' => 'auth'], function () {
    Route::get('whoami', function (){
        dd(Auth::user());
    });

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');

    //Division
    Route::resource('division', 'DivisionController', [
        'except' => ['create', 'show']
    ]);
    Route::get('data/division', 'DivisionController@getData')->name('data.division');
    Route::get('list/division', 'DivisionController@getList')->name('list.division');

    //Division
    Route::resource('incentive', 'IncentiveController', [
        'except' => ['create', 'show']
    ]);
    Route::get('data/incentive', 'IncentiveController@getData')->name('data.incentive');
    Route::get('list/incentive', 'IncentiveController@getList')->name('list.incentive');

    //Employee
    Route::resource('employee', 'EmployeeController', [
        'except' => ['create', 'show']
    ]);
    Route::get('data/employee', 'EmployeeController@getData')->name('data.employee');
    Route::get('list/employee', 'EmployeeController@getList')->name('list.employee');

    //User
    Route::resource('user', 'UserController', [
        'except' => ['create', 'show']
    ]);
    Route::get('data/user', 'UserController@getData')->name('data.user');
    Route::post('change-role/{id}','UserController@changeRole')->name('change.role');

    //PRF
    Route::resource('prf', 'PrfController');
    Route::get('list/prf', 'PrfController@indexListApp');
    Route::get('data/prf', 'PrfController@listApp')->name('data.prf');

    Route::post('approve/prf', 'PrfController@approve');
    Route::post('reject/prf', 'PrfController@reject');
});
