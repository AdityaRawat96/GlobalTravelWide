<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AdminController as AdminController;
use App\Http\Controllers\UserController as UserController;
use App\Http\Controllers\OrderController as OrderController;
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
    Artisan::call('cache:clear');
    echo "cache:clear: complete<br>";
    Artisan::call('config:clear');
    echo "config:clear: complete<br>";
    Artisan::call('view:clear');
    echo "view:clear: complete<br>";
    Artisan::call('optimize:clear');
    echo "optimize:clear: complete<br>";
    Artisan::call('config:cache');
    echo "config:cache: complete<br>";
    Artisan::call('view:cache');
    echo "view:cache: complete<br>";
    Artisan::call('route:clear');
    echo "route:clear: complete<br>";
});

Route::get('/symlink', function () {
    Artisan::call('storage:link');
});

Route::get('/initialize', function () {
    Artisan::call('db:seed --class=RoleSeeder');
    Artisan::call('db:seed --class=AdminSeeder');
});

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/' . Auth::user()->role . '/dashboard');
    }
    return view('auth.login');
});

Auth::routes(['verify' => true]);

// user protected routes
// Route::group(['middleware' => ['auth', 'user', 'verified'], 'prefix' => 'user', 'as' => 'user.'], function () {
//     Route::get('/', [UserController::class, 'index']);
//     Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

//     Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
//         Route::get('/', [OrderController::class, 'index'])->name('index');
//         Route::get('/create', [OrderController::class, 'create'])->name('create');
//         Route::post('/createWithProducts', [OrderController::class, 'createWithProducts'])->name('createWithProducts');
//         Route::get('/view/{orderID}', [OrderController::class, 'userView'])->name('view');
//         Route::get('/edit/{orderID}', [OrderController::class, 'userEdit'])->name('edit');
//         Route::get('/delete/{id}', [OrderController::class, 'delete'])->name('delete');
//         Route::post('/update/{orderID}', [OrderController::class, 'update'])->name('update');
//         Route::post('/seachASIN', [OrderController::class, 'searchASIN'])->name('searchASIN');
//     });
// });

// Disable registration
Route::match(['get', 'post'], 'register', function () {
    return redirect('/');
});

// Admin user role protected routes
Route::group(['middleware' => ['auth', 'role:admin', 'verified'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::resource('user', UserController::class);
});

// Digital user role protected routes
Route::group(['middleware' => ['auth', 'role:digital', 'verified'], 'prefix' => 'digital', 'as' => 'digital.'], function () {
    Route::get('/', function () {
        return redirect()->route('digital.dashboard');
    });
});

// Marketing user role protected routes
Route::group(['middleware' => ['auth', 'role:marketing', 'verified'], 'prefix' => 'marketing', 'as' => 'marketing.'], function () {
    Route::get('/', function () {
        return redirect()->route('marketing.dashboard');
    });
});
