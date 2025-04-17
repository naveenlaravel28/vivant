<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DcMasterController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Site\ReportController as SiteReportController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/save-packing', [HomeController::class, 'savePackings'])->name('save-packing');
    Route::get('/order/edit/{id}', [HomeController::class, 'editOrder'])->name('order.edit');
    Route::post('order/update', [HomeController::class, 'updatePackings'])->name('order.update');
    Route::post('pl/generate', [HomeController::class, 'plGenerate'])->name('pl-generate');
    // Report Module
    Route::prefix('report')->group(function () {
        Route::get('/list', [SiteReportController::class, 'index'])->name('site.report.list');
        Route::get('/pdf/{id}', [SiteReportController::class, 'pdf'])->name('site.report.pdf');
        Route::get('/print/{id}', [SiteReportController::class, 'print'])->name('site.report.print');
        Route::get('/send-pdf/{id}', [SiteReportController::class, 'emailPdf'])->name('site.report.send-pdf');
    });
    // Report Module
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    // Customer Module
    Route::prefix('customer')->group(function () {
        Route::get('/list', [CustomerController::class, 'index'])->name('admin.customer.list');
        Route::post('/save', [CustomerController::class, 'save'])->name('admin.customer.save');
        Route::post('/delete', [CustomerController::class, 'delete'])->name('admin.customer.delete');
    });
    // Customer Module
    
    // DC Master Module
    Route::prefix('dc-master')->group(function () {
        Route::get('/list', [DcMasterController::class, 'index'])->name('admin.dc-master.list');
        Route::post('/save', [DcMasterController::class, 'save'])->name('admin.dc-master.save');
        Route::post('/delete', [DcMasterController::class, 'delete'])->name('admin.dc-master.delete');
    });
    // DC Master Module
    
    // Setting Module
    Route::prefix('setting')->group(function () {
        Route::get('/site', [SettingController::class, 'site'])->name('admin.setting.site');
        Route::get('/account', [SettingController::class, 'account'])->name('admin.setting.account');
        Route::get('/dc-master', [SettingController::class, 'dcMaster'])->name('admin.setting.dc-master');
        Route::get('/password', [SettingController::class, 'passwordUpdate'])->name('admin.setting.password');
        Route::post('/save', [SettingController::class, 'save'])->name('admin.setting.save');
    });
    // Setting Module
    
    // Report Module
    Route::prefix('report')->group(function () {
        Route::get('/list', [ReportController::class, 'index'])->name('admin.report.list');
        Route::get('/pdf/{id}', [ReportController::class, 'pdf'])->name('admin.report.pdf');
        Route::get('/print/{id}', [ReportController::class, 'print'])->name('admin.report.print');
        Route::get('/send-pdf/{id}', [ReportController::class, 'emailPdf'])->name('admin.report.send-pdf');
        Route::get('/status/{id}', [ReportController::class, 'changeStatus'])->name('admin.report.status');
    });
    // Report Module
});

//Artisan Commands
Route::get('migrate', function () {
    Artisan::call('migrate');
    echo "migrated successfully";
});

Route::get('migrate-fresh', function () {
    Artisan::call('migrate:fresh');
    echo "fresh migrated successfully";
});

Route::get('db-seed', function () {
    Artisan::call('db:seed');
    echo "seeding completed";
});

Route::get('storage', function () {
    Artisan::call('storage:link');
    echo "storage linked successfully";
});

Route::get('secure-app', function () {
    Artisan::call('app:secure-app-files');
    echo "app folder has been secured";
});

Route::get('optimize-clear', function () {
    Artisan::call('optimize:clear');
    echo "optimize cleared successfully";
});

Route::get('schedule', function () {
    Artisan::call('schedule:run');
    echo "schedule running...";
});
//Artisan Commands
