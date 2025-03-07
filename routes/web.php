<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;






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
        Route::get('/discounts', [CustomerController::class, 'discount_read'])->name('discounts.read');
        Route::post('/discounts', [CustomerController::class, 'index'])->name('discounts.store');
        Route::get('/discounts/edit', [CustomerController::class, 'edit'])->name('discounts.edit');
        Route::put('/discounts/edit', [CustomerController::class, 'show'])->name('discounts.show');
        
        Route::get('/consumptions', [CustomerController::class, 'consumptions'])->name('consumptions');
    });

    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('/stations', [SettingController::class, 'station_read'])->name('stations.read');
        Route::post('/stations', [SettingController::class, 'stations_create'])->name('stations.create');
        Route::put('/stations/{id}', [SettingController::class, 'stations_update'])->name('stations.update');
        
        Route::get('/discounts', [SettingController::class, 'discount_read'])->name('discounts.read');
        Route::post('/discounts', [SettingController::class, 'settings_discounts_create'])->name('discounts.create');
        
        Route::get('/discount-periods', [SettingController::class, 'discount_periods_read'])->name('discount_periods.read');
        Route::post('/discount-periods', [SettingController::class, 'discount_periods_create'])->name('discount_periods.create');
        Route::put('/discount-periods/{id}', [SettingController::class, 'discount_periods_update'])->name('discount_periods.update');
        
        Route::get('/districts', [SettingController::class, 'districts_read'])->name('districts.read');
        Route::post('/districts', [SettingController::class, 'districts_create'])->name('districts.create');
        Route::put('/districts/{id}', [SettingController::class, 'districts_update'])->name('districts.update');
        
        // Route::get('/consumptions', [CustomerController::class, 'consumptions'])->name('consumptions');
    });

});

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return redirect()->route('admin.dashboard.index');
});

