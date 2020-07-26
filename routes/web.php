<?php

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

// Site root, which is the search results page.
Route::get('/', 'SiteController@search')->name('search');

// API for fetching search data.
Route::prefix('api')->group(function() {
    Route::get('/search', 'ApiController@search')->name('apiSearch');
});
