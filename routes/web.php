<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
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

Route::controller(EmployeeController::class)->group(function (){
    Route::get('/employee-list', 'allEmployee')->name('allEmployee');
    Route::match(['get', 'post'],'/add-employee', 'addEmployee')->name('addEmployee');
    Route::match(['get', 'post'], '/edit-employee/{id}', 'editEmployee')->name('editEmployee');
    Route::get('/delete-employee/{id}', 'deleteEmployee')->name('deleteEmployee');
    Route::get('/view-employee/{id}', 'viewEmployee')->name('viewEmployee');
});

Route::controller(CustomerController::class)->group(function (){
    Route::get('/customer-list', 'allCustomer')->name('allCustomer');
    Route::match(['get', 'post'],'/add-customer', 'addCustomer')->name('addCustomer');
    Route::match(['get', 'post'], '/edit-customer/{id}', 'editCustomer')->name('editCustomer');
    Route::get('/delete-customer/{id}', 'deleteCustomer')->name('deleteCustomer');
    Route::get('/view-customer/{id}', 'viewCustomer')->name('viewCustomer');
});

Route::controller(SupplierController::class)->group(function (){
    Route::match(['get', 'post'], '/add-supplier', 'addSupplier')->name('addSupplier');
    Route::match(['get', 'post'], '/edit-supplier/{id}', 'editSupplier')->name('editSupplier');
    Route::get('/supplier-list', 'allSupplier')->name('allSupplier');
    Route::get('/view-supplier/{id}', 'viewSupplier')->name('viewSupplier');
    Route::get('/delete-supplier/{id}', 'deleteSupplier')->name('deleteSupplier');
});

require __DIR__.'/auth.php';
