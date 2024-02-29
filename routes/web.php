<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [HomeController::class,'welcome']);
Route::get('/about', [AboutController::class,'about']);
Route::get('/hello', [WelcomeController::class,'hello']);
Route::get('/world', function () {
    return 'World';
   });
Route::get('/welcome', function () {
    return 'Welcome';
   });
Route::get('/nama', function () {
    return '2241720253_FahruddinZaimIbrahimWicaksono';
   });
Route::get('/user/{name}', function ($name) {
    return 'My name is '.$name;
    });
Route::get('/posts/{post}/comments/{comment}', function
    ($postId, $commentId) {
     return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
    });
Route::get('/articles/{id}', [ArticleController::class,'articles']);
Route::get('/user/{name?}', function ($name=null) {
        return 'My name is '.$name;
        });
Route::get('/user/{name?}', function ($name='John') {
        return 'Nama saya '.$name;
        });
Route::resource('photos', PhotoController::class)->only([
    'index', 'show'
   ]);
Route::resource('photos', PhotoController::class)->except([
    'create', 'store', 'update', 'destroy'
   ]);
Route::get('/greeting',[WelcomeController::class,'greeting'] );
Route::prefix('products')->group(function () {
    Route::get('/category/food-beverage', [ProductController::class, 'foodBeverage']);
    Route::get('/category/beauty-health', [ProductController::class, 'beautyHealth']);
    Route::get('/category/home-care', [ProductController::class, 'homeCare']);
    Route::get('/category/baby-kid', [ProductController::class, 'babyKid']);
});

Route::get('/user/{id}/name/{name}', [UserController::class, 'show']);

Route::get('/sales', [SalesController::class, 'index']);