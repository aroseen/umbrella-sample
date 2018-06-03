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

/**
 * Генерация короткой ссылки
 */
Route::get('/generateShortUrl', [
    'uses' => 'HomeController@generateShortUrl',
    'as'   => 'home.generate_short_url',
]);

/**
 * Расшарить урл пользователю
 */
Route::post('/share/{url}/{user}', [
    'uses' => 'HomeController@shareUrl',
    'as'   => 'home.shareUrl',
]);

/**
 * Отменить расшаривание урла для пользователя
 */
Route::post('/unshare/{url}/{user}', [
    'uses' => 'HomeController@unshareUrl',
    'as'   => 'home.unshareUrl',
]);

/**
 * Включение / отключение опции расшаривания ссылок
 */
Route::put('/toggleCanShare', [
    'uses' => 'HomeController@toggleCanShare',
    'as'   => 'home.toggleCanShare',
]);

/**
 * Получить список пользователей для расшаривания ссылки
 */
Route::get('/usersToShare/{url}', [
    'uses' => 'HomeController@getUsersToShare',
    'as'   => 'home.usersToShare',
]);

Route::get('/reloadTables', [
    'uses' => 'HomeController@reloadTables',
    'as'   => 'home.reloadTables',
]);
