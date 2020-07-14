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

    //Donatur
    Route::resource('donatur', 'DonaturController', [
        'except' => ['create', 'show']
    ]);
    Route::get('data/donatur', 'DonaturController@getData')->name('data.donatur');
    Route::get('list/donatur', 'DonaturController@getList')->name('list.donatur');
    Route::get('donatur/{id}/donasi', 'DonaturController@getPageListDonasi')->name('page.list.donatur-donasi');
    Route::get('data/{id}/donasi', 'DonaturController@getListDonasi')->name('list.donatur-donasi');
    Route::get('donatur/{id}/anakasuh', 'DonaturController@getPageListAnakAsuh')->name('page.list.donatur-anakasuh');
    Route::get('data/{id}/anakasuh', 'DonaturController@getListAnakAsuh')->name('list.donatur-anakasuh');

    //Anak Asuh
    Route::resource('anakAsuh', 'AnakAsuhController', [
        'except' => ['create', 'show']
    ]);
    Route::get('data/anakAsuh', 'AnakAsuhController@getData')->name('data.anakAsuh');
    Route::get('list/anakAsuh', 'AnakAsuhController@getList')->name('list.anakAsuh');
    Route::get('anakAsuh/download/{filename}', 'AnakAsuhController@downloadProfile');

    //Donasi
    Route::resource('donasi', 'DonasiController', [
        'except' => ['create', 'show']
    ]);
    Route::get('data/donasi', 'DonasiController@getData')->name('data.donasi');
    Route::get('list/donasi', 'DonasiController@getList')->name('list.donasi');
    Route::post('verifikasi-donasi/{id}', 'DonasiController@verifikasi')->name('verifikasi.donasi');
    Route::get('donasi/download/{filename}', 'DonasiController@downloadBukti');

    //REKAP DONASI
    Route::get('rekap/donasi', 'RekapDonasiController@showRekapDonasi')->name('rekap.donasi');
    Route::post('rekap/donasi', 'RekapDonasiController@displayReport')->name('post.rekap.donasi');

    //Donatur Anak Asuh
    Route::post('donatur/anak-asuh', 'DonaturAnakAsuhController@saveDonaturAnakAsuh')->name('post.donatur.anakAsuh');
    Route::delete('donatur/anakAsuh/{id}', 'DonaturAnakAsuhController@deleteDonaturAnakAsuh')->name('delete.donatur.anakAsuh');

    //User
    Route::resource('user', 'UserController', [
        'except' => ['create', 'show']
    ]);
    Route::get('data/user', 'UserController@getData')->name('data.user');
    Route::post('change-role/{id}','UserController@changeRole')->name('change.role');

    Route::resource('acara', 'AcaraController', [
        'except' => ['create', 'show']
    ]);
    Route::get('data/acara', 'AcaraController@getData')->name('data.acara');
    Route::get('acara/{id}/donasi', 'AcaraController@getPageListDonasi')->name('page.list.acara-donasi');
    Route::get('data/{id}/acara-donasi', 'AcaraController@getListDonasi')->name('list.acara-donasi');
});
