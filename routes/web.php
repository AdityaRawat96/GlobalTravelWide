<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PnrController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CommissionsController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Artisan;

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

Route::get('clear-cache', function () {
    Artisan::call('clear-compiled');
    echo "clear-compiled: complete<br>";
    Artisan::call('optimize:clear');
    echo "optimize:clear: complete<br>";
    Artisan::call('route:clear');
    echo "route:clear: complete<br>";
    Artisan::call('view:clear');
    echo "view:clear: complete<br>";
    Artisan::call('view:cache');
    echo "view:cache: complete<br>";
    Artisan::call('cache:clear');
    echo "cache:clear: complete<br>";
    Artisan::call('config:cache');
    echo "config:cache: complete<br>";
    Artisan::call('config:clear');
    echo "config:clear: complete<br>";
});

Route::get('/symlink', function () {
    Artisan::call('storage:link');
});

Route::get('/initialize', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed --class=RoleSeeder');
    Artisan::call('db:seed --class=AdminSeeder');
    Artisan::call('db:seed --class=CompanySeeder');
});

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/' . Auth::user()->role . '/dashboard');
    }
    return view('auth.login');
})->name('home');

Auth::routes(['verify' => true]);

// Disable registration
Route::match(['get', 'post'], 'register', function () {
    return redirect('/');
});

// Admin user role protected routes
Route::group(['middleware' => ['auth', 'role:admin', 'verified'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard.view');
    });

    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('view');
    });

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('view');
        Route::post('/update', [ProfileController::class, 'updateProfileDetails'])->name('update');
        Route::post('/updateEmail', [ProfileController::class, 'updateEmail'])->name('updateEmail');
        Route::post('/updatePassword', [ProfileController::class, 'updatePassword'])->name('updatePassword');
    });

    Route::resource('user', UserController::class);
    Route::get('user/export/{type}', [UserController::class, 'export'])->name('user.export');
    Route::post('user/updatePassword/{user_id}', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    Route::post('user/updateAttendance/{user_id}', [AttendanceController::class, 'updateAttendance'])->name('user.updateAttendance');

    Route::resource('customer', CustomerController::class);
    Route::get('customer/export/{type}', [CustomerController::class, 'export'])->name('customer.export');

    Route::resource('affiliate', AffiliateController::class);
    Route::get('affiliate/export/{type}', [AffiliateController::class, 'export'])->name('affiliate.export');

    Route::resource('catalogue', CatalogueController::class);
    Route::get('catalogue/export/{type}', [CatalogueController::class, 'export'])->name('catalogue.export');

    Route::resource('carrier', CarrierController::class);
    Route::get('carrier/export/{type}', [CarrierController::class, 'export'])->name('carrier.export');

    Route::resource('invoice', InvoiceController::class);
    Route::get('invoice/showPdf/{id}', [InvoiceController::class, 'showPdf'])->name('invoice.showPdf');
    Route::get('invoice/export/{type}', [InvoiceController::class, 'export'])->name('invoice.export');

    Route::resource('refund', RefundController::class);
    Route::get('refund/showPdf/{id}', [RefundController::class, 'showPdf'])->name('refund.showPdf');
    Route::get('refund/export/{type}', [RefundController::class, 'export'])->name('refund.export');

    Route::resource('quotation', QuotationController::class);
    Route::get('quotation/showPdf/{id}', [QuotationController::class, 'showPdf'])->name('quotation.showPdf');
    Route::get('quotation/export/{type}', [QuotationController::class, 'export'])->name('quotation.export');

    Route::resource('sale', SalesController::class);
    Route::get('sale/export/{type}', [SalesController::class, 'export'])->name('sale.export');
    Route::get('sale/exportDetails/{type}', [SalesController::class, 'exportDetails'])->name('sale.exportDetails');
    Route::post('sale/{id}', [SalesController::class, 'show'])->name('sale.show');

    Route::resource('commission', CommissionsController::class);
    Route::get('commission/export/{type}', [CommissionsController::class, 'export'])->name('commission.export');
    Route::get('commission/exportDetails/{type}', [CommissionsController::class, 'exportDetails'])->name('commission.exportDetails');
    Route::post('commission/{id}', [CommissionsController::class, 'show'])->name('commission.show');

    Route::resource('expense', ExpenseController::class);
    Route::get('expense/export/{type}', [ExpenseController::class, 'export'])->name('expense.export');

    Route::resource('notification', NotificationController::class);
    Route::get('notification/export/{type}', [NotificationController::class, 'export'])->name('notification.export');

    Route::resource('pnr', PnrController::class);
    Route::get('pnr/export/{type}', [PnrController::class, 'export'])->name('pnr.export');

    Route::resource('query', QueryController::class);
    Route::get('query/export/{type}', [QueryController::class, 'export'])->name('query.export');

    Route::resource('reminder', ReminderController::class);
    Route::get('reminder/export/{type}', [ReminderController::class, 'export'])->name('reminder.export');

    Route::resource('product', ProductController::class);

    Route::resource('directory', DirectoryController::class);

    Route::resource('attendance', AttendanceController::class);

    Route::resource('attachment', AttachmentController::class);
});

// Staff user role protected routes
Route::group(['middleware' => ['auth', 'role:staff', 'verified'], 'prefix' => 'staff', 'as' => 'staff.'], function () {
    Route::get('/', function () {
        return redirect()->route('staff.dashboard.view');
    });

    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('view');
    });

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('view');
        Route::post('/update', [ProfileController::class, 'updateProfileDetails'])->name('update');
        Route::post('/updateEmail', [ProfileController::class, 'updateEmail'])->name('updateEmail');
        Route::post('/updatePassword', [ProfileController::class, 'updatePassword'])->name('updatePassword');
    });

    Route::resource('customer', CustomerController::class);
    Route::get('customer/export/{type}', [CustomerController::class, 'export'])->name('customer.export');

    Route::resource('affiliate', AffiliateController::class);
    Route::get('affiliate/export/{type}', [AffiliateController::class, 'export'])->name('affiliate.export');

    Route::resource('catalogue', CatalogueController::class);
    Route::get('catalogue/export/{type}', [CatalogueController::class, 'export'])->name('catalogue.export');

    Route::resource('carrier', CarrierController::class);
    Route::get('carrier/export/{type}', [CarrierController::class, 'export'])->name('carrier.export');

    Route::resource('invoice', InvoiceController::class);
    Route::get('invoice/showPdf/{id}', [InvoiceController::class, 'showPdf'])->name('invoice.showPdf');
    Route::get('invoice/export/{type}', [InvoiceController::class, 'export'])->name('invoice.export');

    Route::resource('refund', RefundController::class);
    Route::get('refund/showPdf/{id}', [RefundController::class, 'showPdf'])->name('refund.showPdf');
    Route::get('refund/export/{type}', [RefundController::class, 'export'])->name('refund.export');

    Route::resource('quotation', QuotationController::class);
    Route::get('quotation/showPdf/{id}', [QuotationController::class, 'showPdf'])->name('quotation.showPdf');
    Route::get('quotation/export/{type}', [QuotationController::class, 'export'])->name('quotation.export');

    Route::resource('sale', SalesController::class);
    Route::get('sale/export/{type}', [SalesController::class, 'export'])->name('sale.export');
    Route::get('sale/exportDetails/{type}', [SalesController::class, 'exportDetails'])->name('sale.exportDetails');
    Route::post('sale/{id}', [SalesController::class, 'show'])->name('sale.show');

    Route::resource('commission', CommissionsController::class);
    Route::get('commission/export/{type}', [CommissionsController::class, 'export'])->name('commission.export');
    Route::get('commission/exportDetails/{type}', [CommissionsController::class, 'exportDetails'])->name('commission.exportDetails');
    Route::post('commission/{id}', [CommissionsController::class, 'show'])->name('commission.show');

    Route::resource('notification', NotificationController::class);
    Route::get('notification/export/{type}', [NotificationController::class, 'export'])->name('notification.export');

    Route::resource('pnr', PnrController::class);
    Route::get('pnr/export/{type}', [PnrController::class, 'export'])->name('pnr.export');

    Route::resource('query', QueryController::class);
    Route::get('query/export/{type}', [QueryController::class, 'export'])->name('query.export');

    Route::resource('reminder', ReminderController::class);
    Route::get('reminder/export/{type}', [ReminderController::class, 'export'])->name('reminder.export');

    Route::resource('product', ProductController::class);

    Route::resource('directory', DirectoryController::class);

    Route::resource('attendance', AttendanceController::class);

    Route::resource('attachment', AttachmentController::class);
});

// Other user role protected routes
Route::group(['middleware' => ['auth', 'role:other', 'verified'], 'prefix' => 'other', 'as' => 'other.'], function () {
    Route::get('/', function () {
        return redirect()->route('other.attendance.index');
    });

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('view');
        Route::post('/update', [ProfileController::class, 'updateProfileDetails'])->name('update');
        Route::post('/updateEmail', [ProfileController::class, 'updateEmail'])->name('updateEmail');
        Route::post('/updatePassword', [ProfileController::class, 'updatePassword'])->name('updatePassword');
    });

    Route::resource('directory', DirectoryController::class);

    Route::resource('attendance', AttendanceController::class);

    Route::resource('attachment', AttachmentController::class);
});
