<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Livewire\Products;
use App\Livewire\ProductDetails;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', Products::class)->name('products');
Route::get('/products/{id}', ProductDetails::class)->name('product.details');
