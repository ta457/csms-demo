<?php

use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('admin')->group(function () {
    Route::get('/admin', function () {
        return redirect('/admin/users');
    })->name('admin');

    // user CRUD routes =========================================================
    Route::get(
        '/admin/users',
        [AdminUserController::class, 'index']
    );
    Route::post(
        '/admin/users/filter',
        [AdminUserController::class, 'filter']
    );
    Route::post(
        '/admin/users',
        [AdminUserController::class, 'store']
    );
    Route::delete(
        '/admin/users/{user}',
        [AdminUserController::class, 'destroy']
    );
    Route::post(
        '/admin/users/destroy-all',
        [AdminUserController::class, 'destroyAll']
    );
    Route::get(
        '/admin/users/{user}',
        [AdminUserController::class, 'edit']
    );
    Route::patch(
        '/admin/users/{user}',
        [AdminUserController::class, 'update']
    );

    // product CRUD routes =========================================================
    Route::get(
        '/admin/products',
        [AdminProductController::class, 'index']
    );
    Route::post(
        '/admin/products/filter',
        [AdminProductController::class, 'filter']
    );
    Route::post(
        '/admin/products',
        [AdminProductController::class, 'store']
    );
    Route::delete(
        '/admin/products/{product}',
        [AdminProductController::class, 'destroy']
    );
    Route::post(
        '/admin/products/destroy-all',
        [AdminProductController::class, 'destroyAll']
    );
    Route::get(
        '/admin/products/{product}',
        [AdminProductController::class, 'edit']
    );
    Route::patch(
        '/admin/products/{product}',
        [AdminProductController::class, 'update']
    );
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
