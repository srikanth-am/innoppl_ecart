<?php

use Illuminate\Support\Facades\Route;
//
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
//
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
//
Route::get('/', [ProductController::class, 'index'])->name('products');
Route::get('/product-details/{id}', [ProductController::class, 'GetProductDetails'])->name('product-details');
Route::get('/my-cart', [ProductController::class, 'GetCartView'])->name('my-cart');
Route::post('/my-cart/add', [ProductController::class, 'AddCart'])->name('add-cart');
Route::post('/my-cart/delete', [ProductController::class, 'RemoveCart'])->name('remove-cart');


//
Auth::routes(['register' => false]);//
Route::group(['prefix' => 'admin'], function(){
    Route::get('/', function () { 
        return view('auth.login');//redirect()->to('/login'); 
    });
    Route::get('/products', [AdminController::class, 'GetProducts'])->name('admin-products');
    Route::get('/product/add', [AdminController::class, 'GetCreateProductView'])->name('create-product');
    Route::post('/product/add', [AdminController::class, 'CreateProduct'])->name('create-product');
    Route::get('/product/edit/{id}', [AdminController::class, 'GetEditProductView'])->name('admin-edit-product');
    Route::post('/product/edit/{id}', [AdminController::class, 'EditProduct'])->name('admin-edit-product');
    Route::get('/product-variant/{id}', [AdminController::class, 'GetVariants'])->name('get-product-vairants');
    Route::delete('product/{id}', [AdminController::class, 'DestroyProduct'])->name('delete-product');

    Route::post('/delete-variant/{id}', [AdminController::class, 'DestroyProductVariant'])->name('delete-variant');

});
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
