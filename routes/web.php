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
    return view('index');
});

Route::get('/full-react/{any?}', function () {
    return view('full-react.index');
})->where('any', '.*');

Route::get('/partial-react', function () {
    return view('partial-react.index');
});

Route::get('/laravel', function () {
    return view('laravel.index');
});
