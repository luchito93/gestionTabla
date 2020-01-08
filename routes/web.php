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
    return view('tabla');
});



Auth::routes();

Route::get('/productos', 'ProductoController@index');
Route::post('/productos/guardar', 'ProductoController@store');
Route::put('/productos/actualizar', 'ProductoController@update');
Route::get('/productos/buscar', 'ProductoController@show');
Route::get('/home', 'HomeController@index')->name('home');
