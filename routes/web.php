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
    return view('home1');
});

Route::get('/calendario', function () {
    return view('calendario');
});

Route::get('/calendario2', 'EventosController@calendario')->middleware('auth');
Route::get('/getEventos/{accion?}', 'EventosController@getEventos');
Route::post('/getEventos/{accion?}', 'EventosController@getEventos');
Route::post('/crudTipoEvento/{accion?}', 'EventosController@tipoEvento');
Route::get('/writeMail/{mensaje?}', 'MailController@index')->name('writeMail');
Route::post('/sendMail', 'MailController@sendMail')->name('sendMail');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
