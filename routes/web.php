<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StokController;
use App\Models\BarangModel;
use Maatwebsite\Excel\Row;
use Monolog\Level;

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
Route::get('/',[WelcomeController::class,'index']);
Route::group(['prefix' => 'user'], function() {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/list', [UserController::class, 'list']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
}); 
Route::group(['prefix' => 'level'], function() {
    Route::get('/', [LevelController::class, 'index']);
    Route::post('/list', [LevelController::class, 'list']);
    Route::get('/create', [LevelController::class, 'create']);
    Route::post('/', [LevelController::class, 'store']);
    Route::get('/{id}', [LevelController::class, 'show']);
    Route::get('/{id}/edit', [LevelController::class, 'edit']);
    Route::put('/{id}', [LevelController::class, 'update']);
    Route::delete('/{id}', [LevelController::class, 'destroy']);
});
Route::group(['prefix' => 'kategori'], function() {
    Route::get('/', [KategoriController::class, 'index']);
    Route::post('/list', [KategoriController::class, 'list']);
    Route::get('/create', [KategoriController::class, 'create']);
    Route::post('/', [KategoriController::class, 'store']);
    Route::get('/{id}', [KategoriController::class, 'show']);
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);
    Route::put('/{id}', [KategoriController::class, 'update']);
    Route::delete('/{id}', [KategoriController::class, 'destroy']);
});
Route::group(['prefix' => 'barang'], function() {
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/list', [BarangController::class, 'list']);
    Route::get('/create', [BarangController::class, 'create']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/{id}', [BarangController::class, 'show']);
    Route::get('/{id}/edit', [BarangController::class, 'edit']);
    Route::put('/{id}', [BarangController::class, 'update']);
    Route::delete('/{id}', [BarangController::class, 'destroy']);
});
Route::group(['prefix' => 'stok'], function() {
    Route::get('/', [StokController::class, 'index']);
    Route::post('/list', [StokController::class, 'list']);
    Route::get('/create', [StokController::class, 'create']);
    Route::post('/', [StokController::class, 'store']);
    Route::get('/{id}', [StokController::class, 'show']);
    Route::get('/{id}/edit', [StokController::class, 'edit']);
    Route::put('/{id}', [StokController::class, 'update']);
    Route::delete('/{id}', [StokController::class, 'destroy']);
});
Route::group(['prefix' => 'sales'], function() {
    Route::get('/', [SalesController::class, 'index']);
    Route::post('/list', [SalesController::class, 'list']);
    Route::get('/create', [SalesController::class, 'create']);
    Route::post('/', [SalesController::class, 'store']);
    Route::get('/{id}', [SalesController::class, 'show']);
    Route::get('/{id}/edit', [SalesController::class, 'edit']);
    Route::put('/{id}', [SalesController::class, 'update']);
    Route::delete('/{id}', [SalesController::class, 'destroy']);
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register'); 
Route::post('proses_login', [AuthController::class, 'proses_login'])->name('proses_login'); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('proses_register', [AuthController::class, 'proses_register'])->name('proses_register');
// kita atur juga untuk middleware menggunakan group pada routing
// didalamnya terdapat group untuk mengecek kondisi login
// jika user yang login merupakan admin maka akan diarahkan ke AdminController
// jika user yang login merupakan manager maka akan diarahkan ke UserController 
Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['cek_login:1']], function () { 
        Route::resource('admin', AdminController::class);
    });
    Route::group(['middleware' => ['cek_login:2']], function () { 
        Route::resource('manager', ManagerController::class);
    });
});
Route::get('/about', [AboutController::class,'about']);
Route::get('/hello', [WelcomeController::class,'hello']);
Route::get('/world', function () {
    return 'World';
   });
Route::get('/welcome', function () {
    return 'Welcome';
   });
Route::get('/posts/{post}/comments/{comment}', function
    ($postId, $commentId) {
     return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
    });
Route::get('/articles/{id}', [ArticleController::class,'articles']);
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

//Route::get('/user/{id}/name/{name}', [UserController::class, 'show']);

Route::get('/sales', [SalesController::class, 'index']);

//Route::get('/level', [LevelController::class, 'index']);
//Route::get('/level/tambah',[LevelController::class,'tambah'])->name('/level/tambah');
//Route::get('/level/tambah_simpan',[LevelController::class,'tambah_simpan'])->name('/level/tambah_simpan');
//Route::get('/kategori', [KategoriController::class, 'index']);
//Route::get('/kategori/create', [KategoriController::class, 'create']);
//Route::post('/kategori', [KategoriController::class, 'store']);
//Route::get('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
//Route::put('/kategori/update_save/{id}', [KategoriController::class, 'update_save'])->name('kategori.update_save');
//Route::get('/kategori/delete/{id}', [KategoriController::class, 'delete'])->name('kategori.delete');
//Route::get('/user', [UserController::class, 'index'])->name('/user');
//Route::get('/user/count', [UserController::class, 'index']);
//Route::get('/user/tambah',[UserController::class,'tambah'])->name('/user/tambah');
//Route::get('/user/ubah/{id}',[UserController::class,'ubah'])->name('/user/ubah');
//Route::get('/user/hapus/{id}',[UserController::class,'hapus'])->name('/user/hapus');
//Route::post('/user/tambah_simpan',[UserController::class, 'tambah_simpan'])->name('/user/tambah_simpan');
//Route::put('/user/ubah_simpan/{id}',[UserController::class, 'ubah_simpan'])->name('/user/ubah_simpan');
//Route::resource('m_user', POSController::class);
