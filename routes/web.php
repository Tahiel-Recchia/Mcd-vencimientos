<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrintController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

Route::get('/', [CategoryController::class, 'index'])->name('index');
Route::get('/category/{category}', [CategoryController::class, 'getProductsFromCategory'])->name('category.products');
Route::post('/product/{product}', [ProductController::class, 'viewExpirationRules'])->name('product.rules');
Route::post('/print/{rule}', [PrintController::class, 'print'])->name('print.ticket');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.view');
Route::delete('/active-timers/{id}/{categoryId}', [DashboardController::class, 'deleteTimer'])->name('timers.destroy');
Route::get('/globalDashboard/', [DashboardController::class, 'globalDashboard'])->name('dashboard.global');
Route::put('/updateTimer/{id}', [DashboardController::class, 'updateTimer'])->name('timers.update');
Route::get('/timers/{id}/categories', [DashboardController::class, 'getCategoriesFromProduct']);
Route::post('/import-timer/{timer}/{category}', [DashboardController::class, 'importTimer'])->name('timers.import');
