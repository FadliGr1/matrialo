<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AWSController;

// Welcome Route
Route::get('/', [PagesController::class, 'welcome'])->name('welcome')->middleware(RedirectIfAuthenticated::class);
Route::post('/login-process', [AuthController::class, 'loginProcess']);
Route::get('/logout', [AuthController::class, 'logout']);

// Administrator/Superadmin/Manager Route
Route::middleware(['admin'])->group(function () {
    Route::get('/dashboard', [PagesController::class, 'dashboardIndex']);
    Route::get('/user', [PagesController::class, 'dashboardUser']);
    Route::get('/user/{id}', [PagesController::class, 'show'])->name('user.show');
    Route::get('/get-user/{id}', [PagesController::class, 'getUser'])->name('user.getUser');
    Route::get('/ajax-search', [PagesController::class, 'ajaxSearch'])->name('ajax.search');
    Route::post('/user', [PagesController::class, 'storeUser'])->name('user.store');
    Route::get('/export-users', [ExportController::class, 'exportUsers'])->name('export.users');

    Route::get('/vendor', [VendorController::class, 'create'])->name('vendor.create');
    Route::post('/vendor', [VendorController::class, 'store'])->name('vendor.store');
    Route::get('/api/vendors/{id}', [VendorController::class, 'show']);

    Route::get('/setting', [PagesController::class, 'showSetting']);
    Route::get('/setting/profile', [PagesController::class, 'settingProfile']);
    Route::post('/setting/profile', [PagesController::class, 'updateSetting'])->name('setting.update');
    Route::get('setting/security', [PagesController::class, 'settingSecurity']);
    Route::post('setting/security', [PagesController::class, 'updateSecurity'])->name('security.update');

    Route::get('/setting/app', [PagesController::class, 'settingApp']);
    Route::get('/setting/integration', [AWSController::class, 'showConfigForm'])->name('aws.config');
    Route::post('/setting/integration', [AWSController::class, 'saveConfig'])->name('aws.saveConfig');
    Route::post('/setting/integration/test-connection', [AWSController::class, 'testConnection'])->name('aws.testConnection');
});
