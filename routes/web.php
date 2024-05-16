<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

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
    return view('dashboard.dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(CategoryController::class)->group(function (){
    Route::get('/category-list', 'allCategory')->name('allCategory');
    Route::match(['get', 'post'],'/add-category', 'addCategory')->name('addCategory');
    Route::match(['get', 'post'], '/edit-category/{id}', 'editCategory')->name('editCategory');
    Route::get('/delete-category/{id}', 'deleteCategory')->name('deleteCategory');
});

Route::controller(ProductController::class)->group(function (){
    Route::get('/product-list', 'allProduct')->name('allProduct');
    Route::match(['get', 'post'],'/add-product', 'addProduct')->name('addProduct');
    Route::match(['get', 'post'], '/edit-product/{id}', 'editProduct')->name('editProduct');
    Route::get('/delete-product/{id}', 'deleteProduct')->name('deleteProduct');
});

require __DIR__.'/auth.php';
