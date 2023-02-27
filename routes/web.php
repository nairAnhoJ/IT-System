<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DeptInChargeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemRequestController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\PhoneSimController;
use App\Http\Controllers\PhoneSimRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SAPController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TicketCategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Models\DeptInCharge;
use App\Models\PhoneSim;
use App\Models\TicketCategory;
use Illuminate\Support\Facades\DB;
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
    $userDeptID = auth()->user()->dept_id;
    // $userRow = DB::table('users')->where('id', $userID)->get();
    // $userDeptID = $userRow[0]->dept_id;
    $userDept = DB::table('departments')->where('id', $userDeptID)->get()[0]->name;
    $deptInCharge = (DB::table('dept_in_charges')->where('id', 1)->first())->dept_id;

    if($userDeptID != $deptInCharge){
        $tickets = DB::select("SELECT tickets.id, tickets.ticket_no, u.name AS user, departments.name AS dept, ticket_categories.name AS nature_of_problem, a.name AS assigned_to, tickets.subject, tickets.description, tickets.status, tickets.created_at, tickets.attachment, tickets.resolution FROM tickets INNER JOIN users AS u ON tickets.user_id = u.id INNER JOIN departments ON tickets.department = departments.id INNER JOIN users AS a ON tickets.assigned_to = a.id INNER JOIN ticket_categories ON tickets.nature_of_problem = ticket_categories.id WHERE tickets.status = 'PENDING' || tickets.status = 'ONGOING' AND department = ? ORDER BY tickets.id DESC", [$userDeptID]);

        $ticketReq = DB::select("SELECT COUNT(*) AS count FROM tickets WHERE user_id = ? AND status != 'CANCELLED' AND status != 'DONE'", [auth()->user()->id]);
        $pending = DB::select("SELECT COUNT(*) AS count FROM tickets WHERE user_id = ? AND status = 'PENDING'", [auth()->user()->id]);
        $ongoing = DB::select("SELECT COUNT(*) AS count FROM tickets WHERE user_id = ? AND status = 'ONGOING'", [auth()->user()->id]);
    }else{
        $tickets = DB::select("SELECT tickets.id, tickets.ticket_no, u.name AS user, departments.name AS dept, ticket_categories.name AS nature_of_problem, a.name AS assigned_to, tickets.subject, tickets.description, tickets.status, tickets.created_at, tickets.attachment, tickets.resolution FROM tickets INNER JOIN users AS u ON tickets.user_id = u.id INNER JOIN departments ON tickets.department = departments.id INNER JOIN users AS a ON tickets.assigned_to = a.id INNER JOIN ticket_categories ON tickets.nature_of_problem = ticket_categories.id WHERE tickets.status = 'PENDING' || tickets.status = 'ONGOING' ORDER BY tickets.id DESC");

        $ticketReq = DB::select("SELECT COUNT(*) AS count FROM tickets WHERE assigned_to = ? AND status != 'CANCELLED' AND status != 'DONE'", [auth()->user()->id]);
        $pending = DB::select("SELECT COUNT(*) AS count FROM tickets WHERE status = 'PENDING'");
        $ongoing = DB::select("SELECT COUNT(*) AS count FROM tickets WHERE status = 'ONGOING'");
    }
    return view('dashboard', compact('userDept', 'tickets', 'deptInCharge', 'userDeptID', 'ticketReq', 'pending', 'ongoing'));
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
    Route::get('/ticketing/reports', [TicketController::class, 'report'])->name('ticket.reports');
    Route::post('/ticketing/reports', [TicketController::class, 'genReport'])->name('ticket.genReports');
    
    Route::get('/ticketing/sap', [SAPController::class, 'index'])->name('sap.index');
    Route::post('/ticketing/sap/edit', [SAPController::class, 'edit'])->name('sap.edit');
    Route::post('/ticketing/sap/store', [SAPController::class, 'store'])->name('sap.store');

    // Items
    Route::get('/inventory/items', [ItemController::class, 'index'])->name('item.index');
    Route::get('/inventory/items/add', [ItemController::class, 'add'])->name('item.add');
    Route::post('/inventory/items/store', [ItemController::class, 'store'])->name('item.store');
    Route::get('/inventory/items/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
    Route::post('/inventory/items/update', [ItemController::class, 'update'])->name('item.update');
    Route::post('/inventory/items/delete', [ItemController::class, 'delete'])->name('item.delete');
    Route::post('/inventory/items/mark-as-defective', [ItemController::class, 'defective'])->name('item.defective');
    Route::get('/inventory/items/invoice-download/{id}', [ItemController::class, 'download']);

    Route::get('/inventory/items/defective', [ItemController::class, 'defectiveIndex'])->name('defectiveIndex.index');
    Route::post('/inventory/items/defective/restore', [ItemController::class, 'defectiveRestore'])->name('defectiveIndex.restore');

    // Item Request
    Route::get('/request/items', [ItemRequestController::class, 'index'])->name('reqItem.index');
    Route::get('/request/items/add', [ItemRequestController::class, 'add'])->name('reqItem.add');
    Route::post('/request/items/store', [ItemRequestController::class, 'store'])->name('reqItem.store');
    Route::get('/request/items/edit/{id}', [ItemRequestController::class, 'edit'])->name('reqItem.edit');
    Route::post('/request/items/update', [ItemRequestController::class, 'update'])->name('reqItem.update');
    Route::get('/request/items/delivered/{id}', [ItemRequestController::class, 'statusD'])->name('reqItem.del');
    Route::post('/request/items/delete', [ItemRequestController::class, 'delete'])->name('reqItem.delete');;
    Route::post('/request/items/status-update', [ItemRequestController::class, 'statusUpdate'])->name('reqItem.statusUpdate');
    Route::post('/request/items/status-delivered', [ItemRequestController::class, 'statusDelivered'])->name('reqItem.statusDelivered');
    
    // Phone SIM
    Route::get('/inventory/phone-sim', [PhoneSimController::class, 'index'])->name('phoneSim.index');
    Route::get('/inventory/phone-sim/add', [PhoneSimController::class, 'add'])->name('phoneSim.add');
    Route::post('/inventory/phone-sim/store', [PhoneSimController::class, 'store'])->name('phoneSim.store');
    Route::get('/inventory/phone-sim/edit/{id}', [PhoneSimController::class, 'edit'])->name('phoneSim.edit');
    Route::post('/inventory/phone-sim/update', [PhoneSimController::class, 'update'])->name('phoneSim.update');
    Route::post('/inventory/phone-sim/delete', [PhoneSimController::class, 'delete'])->name('phoneSim.delete');
    Route::post('/inventory/phone-sim//mark-as-defective', [PhoneSimController::class, 'defective'])->name('phoneSim.defective');
    Route::get('/inventory/phone-sim/invoice-download/{id}', [PhoneSimController::class, 'download']);

    Route::get('/inventory/phone-sim/defective', [PhoneSimController::class, 'defectivePhoneIndex'])->name('defectivePhone.index');
    Route::post('/inventory/phone-sim/defective/restore', [PhoneSimController::class, 'defectivePhoneRestore'])->name('defectivePhone.restore');

    // Phone SIM Request
    Route::get('/request/phone-sim', [PhoneSimRequestController::class, 'index'])->name('reqPhoneSim.index');
    Route::get('/request/phone-sim/add', [PhoneSimRequestController::class, 'add'])->name('reqPhoneSim.add');
    Route::post('/request/phone-sim/store', [PhoneSimRequestController::class, 'store'])->name('reqPhoneSim.store');
    Route::get('/request/phone-sim/edit/{id}', [PhoneSimRequestController::class, 'edit'])->name('reqPhoneSim.edit');
    Route::post('/request/phone-sim/update', [PhoneSimRequestController::class, 'update'])->name('reqPhoneSim.update');
    Route::get('/request/phone-sim/delivered/{id}', [PhoneSimRequestController::class, 'statusD'])->name('reqPhoneSim.del');;
    Route::post('/request/phone-sim/delete', [PhoneSimRequestController::class, 'delete'])->name('reqPhoneSim.delete');
    Route::post('/request/phone-sim/status-update', [PhoneSimRequestController::class, 'statusUpdate'])->name('reqPhoneSim.statusUpdate');
    Route::post('/request/phone-sim/status-delivered', [PhoneSimRequestController::class, 'statusDelivered'])->name('reqPhoneSim.statusDelivered');



    // Computer
    Route::get('/inventory/computers', [ComputerController::class, 'index'])->name('computer.index');
    Route::get('/inventory/computers/add', [ComputerController::class, 'add'])->name('computer.add');
    Route::post('/inventory/computers/store', [ComputerController::class, 'store'])->name('computer.store');
    Route::get('/inventory/computers/edit/{id}', [ComputerController::class, 'edit'])->name('computer.edit');
    Route::post('/inventory/computers/update', [ComputerController::class, 'update'])->name('computer.update');
    Route::post('/inventory/computers/getSpecs', [ComputerController::class, 'view'])->name('computer.view');




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

        // Items Type
        Route::get('/system-management/item-type', [ItemTypeController::class, 'index'])->name('itemType.index');
        Route::post('/system-management/item-type/add', [ItemTypeController::class, 'add'])->name('itemType.add');
        Route::post('/system-management/item-type/edit', [ItemTypeController::class, 'edit'])->name('itemType.edit');
        Route::post('/system-management/item-type/delete', [ItemTypeController::class, 'delete'])->name('itemType.delete');

        // Sites
        Route::get('/system-management/site', [SiteController::class, 'index'])->name('site.index');
        Route::post('/system-management/site/add', [SiteController::class, 'add'])->name('site.add');
        Route::post('/system-management/site/edit', [SiteController::class, 'edit'])->name('site.edit');
        Route::post('/system-management/site/delete', [SiteController::class, 'delete'])->name('site.delete');

        // Settings
        Route::get('/system-management/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/system-management/settings/update', [SettingController::class, 'update'])->name('settings.update');
        Route::post('/system-management/settings/test-connection', [SettingController::class, 'test'])->name('settings.test');

    // ========================================= SYSTEM MANAGEMENT END =========================================

});

require __DIR__.'/auth.php';
