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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes(['register' => false]);

Route::get('/home', function () {
    return view('vendor.adminlte.admin.categories');
})->name('home')->middleware('auth');

Route::middleware(['auth'])->prefix('/admin')->group(function () {

    Route::get('/categories', function () {
        return view('vendor.adminlte.admin.categories');
    })->name('categories');

    Route::get('/products', function () {
        return view('vendor.adminlte.admin.products');
    })->name('products');

    Route::get('/users', function () {
        return view('vendor.adminlte.admin.users');
    })->name('users');
});
