<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\MvendorController;
use App\Http\Controllers\MwarehouseController;
use App\Http\Controllers\MprojectController;
use App\Http\Controllers\SettingController;


Route::middleware('auth')->group(function () {
    // Admin or Manager Routes
    Route::middleware('role:manager')->prefix('manager')->group(function () {
        Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
        Route::get('/dashboard', [ActivityController::class, 'index'])->name('manager.dashboard');

        // manage user route
        Route::get('/user', [ManagerController::class, 'user'])->name('manager.user');
        Route::get('/user', [UserController::class, 'getData'])->name('manager.user');
        Route::post('/user/store', [UserController::class, 'store'])->name('manager.user.store');
        Route::put('/user/update', [UserController::class, 'update'])->name('manager.user.update');
        Route::put('/user/password/update', [UserController::class, 'updatePassword'])->name('manager.user.password.update');
        Route::delete('/user/bulk-destroy', [UserController::class, 'bulkDestroy'])->name('manager.user.bulk-destroy');
        Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('manager.user.destroy');

        // manage vendor route
        Route::get('/vendor', [ManagerController::class, 'vendor'])->name('manager.vendor');
        Route::get('/vendor', [MvendorController::class, 'getData'])->name('manager.vendor');
        Route::post('/vendor/store', [MvendorController::class, 'store'])->name('manager.vendor.store');
        Route::put('/vendor/{vendor}', [MvendorController::class, 'update'])->name('manager.vendor.update');
        Route::delete('/vendor/bulk-destroy', [MvendorController::class, 'bulkDestroy'])->name('manager.vendor.bulk-destroy');
        Route::delete('/vendor/{vendor}', [MvendorController::class, 'destroy'])->name('manager.vendor.destroy');

        // manage warehouse route
        Route::get('/warehouse', [ManagerController::class, 'warehouse'])->name('manager.warehouse');
        Route::get('/warehouse', [MwarehouseController::class, 'getData'])->name('manager.warehouse');
        Route::post('/warehouse/store', [MwarehouseController::class, 'store'])->name('manager.warehouse.store');
        Route::put('/warehouse/{warehouse}', [MwarehouseController::class, 'update'])->name('manager.warehouse.update');
        Route::delete('/warehouse/bulk-destroy', [MwarehouseController::class, 'bulkDestroy'])->name('manager.warehouse.bulk-destroy');
        Route::delete('/warehouse/{warehouse}', [MwarehouseController::class, 'destroy'])->name('manager.warehouse.destroy');

        // manage project route
        Route::get('/project', [ManagerController::class, 'project'])->name('manager.project');
        Route::get('/project', [MprojectController::class, 'getData'])->name('manager.project');
        Route::post('/project/store', [MprojectController::class, 'store'])->name('manager.project.store');
        Route::put('/project/{project}', [MprojectController::class, 'update'])->name('manager.project.update');
        Route::delete('/project/bulk-destroy', [MprojectController::class, 'bulkDestroy'])->name('manager.project.bulk-destroy');
        Route::delete('/project/{project}', [MprojectController::class, 'destroy'])->name('manager.project.destroy');
        
    });

    // Vendor Routes
    Route::middleware('role:vendor')->prefix('vendor')->group(function () {
        Route::get('/dashboard', 'VendorController@dashboard')->name('vendor.dashboard');
       
    });

    // Warehouse Routes
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
        
    });

    // Staff or Project Manager Routes
    Route::middleware('role:staff')->prefix('staff')->group(function () {
        Route::get('/dashboard', 'StaffController@dashboard')->name('staff.dashboard');
       
    });

    // Setting Route
    Route::get('/manager/setting', [SettingController::class, 'index'])->name('manager.setting');
    Route::post('/settings/general', [SettingController::class, 'updateGeneralSettings'])->name('settings.general.update');
    Route::post('/settings/mail', [SettingController::class, 'updateMailSettings'])->name('settings.mail.update');
    Route::post('/settings/mail/test', [SettingController::class, 'testMail'])->name('settings.mail.test');
    Route::get('/vendor/setting', [SettingController::class, 'index'])->name('vendor.setting');
    Route::get('/staff/setting', [SettingController::class, 'index'])->name('staff.setting');
    Route::get('/admin/setting', [SettingController::class, 'index'])->name('admin.setting');
    Route::post('/settings/storage', [SettingController::class, 'updateStorageSettings'])->name('settings.storage.update');
    Route::post('/settings/storage/test', [SettingController::class, 'testStorage'])->name('settings.storage.test');
});

// Authentication Route
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login'])->middleware('throttle:login')->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');