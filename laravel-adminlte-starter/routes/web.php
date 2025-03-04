<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard.index');
});

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::resource('roles', RoleController::class)->except(['show']);
        Route::resource('permissions', PermissionController::class)->except(['show']);
        Route::resource('users', UserController::class);
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    

    Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {
        Route::get('/discounts', [CustomerController::class, 'index'])->name('discounts.index');
        Route::get('/discounts/edit', [CustomerController::class, 'edit'])->name('discounts.edit');
        Route::put('/discounts/edit', [CustomerController::class, 'show'])->name('discounts.show');
        
        Route::get('/consumptions', [CustomerController::class, 'consumptions'])->name('consumptions');
    });
});

require __DIR__ . '/auth.php';
