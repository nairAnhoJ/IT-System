<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DeptInChargeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TicketCategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Models\DeptInCharge;
use App\Models\TicketCategory;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(!auth()->user()){
        return view('auth.login');
    }else{
        return redirect()->route('dashboard');
    }
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ticketing
    Route::get('/ticketing/dashboard', [TicketController::class, 'index'])->name('ticket.index');
    Route::get('/ticketing/create', [TicketController::class, 'create'])->name('ticket.create');
    Route::post('/ticketing/store', [TicketController::class, 'store'])->name('ticket.store');
    Route::post('/ticketing/temp', [TicketController::class, 'temp'])->name('ticket.temp');
    Route::post('/ticketing/update', [TicketController::class, 'update'])->name('ticket.update');

    // Items
    Route::get('/inventory/items', [ItemController::class, 'index'])->name('item.index');
    Route::post('/inventory/items/add', [ItemController::class, 'add'])->name('item.add');
    Route::post('/inventory/items/store', [ItemController::class, 'store'])->name('item.store');


    // Computer
    Route::get('/inventory/computers', [ComputerController::class, 'index'])->name('computer.index');




    // ========================================= SYSTEM MANAGEMENT =========================================
        // Department
        Route::get('/system-management/departments', [DepartmentController::class, 'index'])->name('department.index');
        Route::post('/system-management/departments/add', [DepartmentController::class, 'add'])->name('department.add');
        Route::post('/system-management/departments/edit', [DepartmentController::class, 'edit'])->name('department.edit');
        Route::post('/system-management/departments/delete', [DepartmentController::class, 'delete'])->name('department.delete');

        // User
        Route::get('/system-management/user', [UserController::class, 'index'])->name('user.index');
        Route::post('/system-management/user/add', [RegisteredUserController::class, 'store'])->name('user.add');
        Route::post('/system-management/user/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/system-management/user/update', [UserController::class, 'update'])->name('user.update');
        Route::post('/system-management/user/delete', [UserController::class, 'delete'])->name('user.delete');

        // Ticket Category
        Route::get('/system-management/ticket-category', [TicketCategoryController::class, 'index'])->name('category.index');
        Route::post('/system-management/ticket-category/add', [TicketCategoryController::class, 'add'])->name('category.add');
        Route::post('/system-management/ticket-category/edit', [TicketCategoryController::class, 'edit'])->name('category.edit');
        Route::post('/system-management/ticket-category/delete', [TicketCategoryController::class, 'delete'])->name('category.delete');
        Route::post('/system-management/ticket-category/update-in-charge', [DeptInChargeController::class, 'update'])->name('incharge.update');

        // Settings
        Route::get('/system-management/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/system-management/settings/update', [SettingController::class, 'update'])->name('settings.update');
        Route::post('/system-management/settings/test-connection', [SettingController::class, 'test'])->name('settings.test');

    // ========================================= SYSTEM MANAGEMENT END =========================================

});

require __DIR__.'/auth.php';
