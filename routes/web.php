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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/getData', 'Karyawan@getData');
Route::get('/delete/{id}', 'Karyawan@hapus');
Route::get('/getDetail/{id}', 'Karyawan@getDetail');
