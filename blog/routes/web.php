<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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



Auth::routes();

Route::middleware('auth')
    ->namespace('Admin')
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {

        // admin
        Route::get('/', 'HomeController@index')->name('home');

        //posts= rotta di risorsa
        Route::resource('/posts', 'PostController');

        //rotta per la categoria
        Route::get('/categories/{id}', 'CategoryController@show')->name('category');
    });


// home front -> sempre alla fine
Route::get('{any?}', function () {
    return view('guests.home');
})->where('any', '.*');
