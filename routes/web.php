<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CheckoutController as AdminCheckout;


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
  return view('welcome');
})->name('welcome');

// Route::get('checkout/{camp:slug}', function () {
//   return view('checkout');
// })->name('checkout');
Route::middleware(['auth'])->group(function () {

  //checkout routes
  Route::get('checkout/success}', [CheckoutController::class, 'success'])->name('checkout.success')->middleware('esureUserRole:user');
  Route::get('checkout/{camp:slug}', [CheckoutController::class, 'create'])->name('checkout.create')->middleware('esureUserRole:user');
  Route::post('checkout/{camp}', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('esureUserRole:user');


  //user dashboard
  Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
  Route::get('dashboard/checkout/invoice/{checkout}', [CheckoutController::class, 'invoice'])->name('user.checkout.invoice');
});

//socialite routes

Route::get('sign-in-google', [UserController::class, 'google'])
  ->name('user.login.google');

Route::get('auth/google/callback', [UserController::class, 'handleProviderCallback'])->name('user.google.callback');

//midtrans routes

Route::get('payment/success', [CheckoutController::class, 'midtransCallback']);

Route::post('payment/success', [CheckoutController::class, 'midtransCallback']);

//user dashboard
Route::prefix('user/dashboard')->namespace('User')->name('user.')->middleware('esureUserRole:user')->group(function () {
  Route::get('/', [UserDashboard::class, 'index'])->name('dashboard');
});


//admin dashboard
Route::prefix('admin/dashboard')->namespace('Admin')->name('admin.')->middleware('esureUserRole:admin')->group(function () {
  Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');

  //admin checkout

  Route::post('checkout/{checkout}', [AdminCheckout::class, 'update'])->name('checkout.update');
});

// Route::get('/dashboard', function () {
//   return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';