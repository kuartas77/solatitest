<?php

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect(route('home'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/{user}', 'HomeController@show')->name('user');
Route::get('/users', 'HomeController@users')->name('users');
Route::post('/users', 'HomeController@store')->name('user.store');
Route::put('/users/{user}', 'HomeController@update')->name('user.update');
Route::delete('/users/{user}', 'HomeController@delete')->name('user.delete');
