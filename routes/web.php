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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * Главная + роуты аутентификации
 */
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

/**
 * Создание новой ссылки
 */

Route::post('/create', [
    'uses' => 'HomeController@create',
    'as'   => 'home.create',
]);
