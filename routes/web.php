<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AjaxController;

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
    return redirect('/home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::match(['get', 'post'], '/main', [CompanyController::class, 'companyInfo'])->middleware('auth');
Route::match(['get', 'post'], '/main/edit', [CompanyController::class, 'infoEdit'])->middleware('auth');
Route::match(['get', 'post'], '/product/new', [ProductController::class, 'addNewProduct'])->middleware('auth');
Route::match(['get', 'post'], '/product/edit/{id}', [ProductController::class, 'editProduct'])->middleware('auth');
Route::match(['get', 'post'], '/product/delete/{id}', [ProductController::class, 'deleteProduct'])->middleware('auth');
Route::match(['get', 'post'], '/product/view/{id}', [ProductController::class, 'viewProduct'])->middleware('auth');

Route::match(['get', 'post'], '/changeCount', [AjaxController::class, 'changeCount'])->middleware('auth');
