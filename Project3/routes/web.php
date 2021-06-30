<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
// Route::get('/', function () {
//     return view('welcome');
// });
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home/show', [HomeController::class, 'orderSh']);
Route::post('/home/SorderID', [HomeController::class, 'SearchID']);
Route::get('/orderproduct', [OrderProductController::class, 'index'])->name('orderproduct');
Route::post('/orderproduct/order', [OrderProductController::class, 'orderpro']);
Route::delete('/orderproduct/dall', [OrderProductController::class, 'del']);
// category/post
Route::get('/category', [CategoryController::class, 'index'])->name('category');
Route::post('/category/post', [CategoryController::class, 'store']);
Route::post('/category/search', [CategoryController::class, 'search']);
Route::put('/category/update/{id}', [CategoryController::class, 'update']);
Route::get('/category/get', [CategoryController::class, 'getcate']);
Route::delete('/category/delete/{id}', [CategoryController::class, 'del']);
// product
Route::get('/productitem', [ProductController::class, 'index'])->name('product');
Route::put('/productitem/update/{id}', [ProductController::class, 'update']);
Route::post('/productitem/search', [ProductController::class, 'search']);
Route::delete('/productitem/delete/{id}', [ProductController::class, 'del']);
Route::post('/product/post', [ProductController::class, 'storepro']);
Route::get('/product/get', [ProductController::class, 'getpro']);
Route::post('/product/search', [ProductController::class, 'searchpro']);