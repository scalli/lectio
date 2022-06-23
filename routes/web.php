<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/text/{layout}/{id}', 'App\Http\Controllers\ReadTextController@show');
Route::get('/text/new', 'App\Http\Controllers\TextController@new')->name('newtext');


Route::get('/voc/{layout}/{id}', 'App\Http\Controllers\VocController@show');
Route::get('/voc/repetitio/step/1', 'App\Http\Controllers\VocController@repetitioStep1');
Route::post('/voc/repetitio/step/2', 'App\Http\Controllers\VocController@repetitioStep2');
Route::post('/voc/repetitio/export', 'App\Http\Controllers\VocController@export');
Route::post('/voc/downloadvoc','App\Http\Controllers\VocController@downloadvoc');
Route::post('/voc','App\Http\Controllers\VocController@store');

Route::get('/overview', 'App\Http\Controllers\TextInfoController@show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
