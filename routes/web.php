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

Route::get('/broadcast/create', [\App\Http\Controllers\BroadcastController::class, 'index'])->name('broadcast');
Route::post('/broadcast',[\App\Http\Controllers\BroadcastController::class, 'send'])->name('send');
Route::get('/broadcast/log', [App\Http\Controllers\BroadcastController::class, 'log'])->name('broadcastLog');
Route::get('/broadcast/log/{id?}', [App\Http\Controllers\BroadcastController::class, 'log_details'])->name('log_details');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
