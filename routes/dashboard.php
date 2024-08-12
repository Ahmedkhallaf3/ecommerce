

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\Dashboard\AdminsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ImportProductsController;


//Route::group(['middleware'=>['auth','auth.type:user,admin,super-admin']],function(){
// Route::group(['middleware' => ['auth:admin,web','prefix' => 'admin']], function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//     Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/dashboard/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::resource('/dashboard/product', ProductController::class);
//     Route::get('/dashboard/category/trash', [CategoriesController::class, 'trash'])->name('category.trash');
//     Route::put('/dashboard/category/{category}/restore', [CategoriesController::class, 'restore'])->name('category.restore');
//     Route::delete('/dashboard/category/{category}/force-delete', [CategoriesController::class, 'forceDelete'])->name('category.forceDelete');

//     Route::resource('/dashboard/category', CategoriesController::class);
// });
Route::group(['middleware' => ['auth:admin,web'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Product routes
    // Route::resource('/dashboard/product', ProductController::class);

    // Category routes
    Route::get('/dashboard/category/trash', [CategoriesController::class, 'trash'])->name('category.trash');
    Route::put('/dashboard/category/{category}/restore', [CategoriesController::class, 'restore'])->name('category.restore');
    Route::delete('/dashboard/category/{category}/force-delete', [CategoriesController::class, 'forceDelete'])->name('category.forceDelete');
    // Route::resource('/dashboard/category', CategoriesController::class);

    Route::get('dashboard/product/import', [ImportProductsController::class, 'create'])
        ->name('product.import');
    Route::post('dashboard/product/import', [ImportProductsController::class, 'store']);

    Route::resources([
        'dashboard/product' => ProductController::class,
        'dashboard/category' => CategoriesController::class,
        'dashboard/roles' => RolesController::class,
        'users' => UsersController::class,
        'dashboard/admins' => AdminsController::class,
    ]);
});





Route::middleware('auth')->group(function () {
});
