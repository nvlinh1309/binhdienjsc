<?php
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\UserController;
use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Order\OrderController;
use App\Http\Controllers\User\Product\ProductController;
use App\Http\Controllers\User\Supplier\SupplierController;
use App\Http\Controllers\User\Customer\CustomerController;
use App\Http\Controllers\User\Storage\StorageController;
use App\Http\Controllers\User\Users\UsersController;
use App\Http\Controllers\User\Brand\BrandController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/admin', function () {
//     return view('auth.login');
// })->name('login');

// Route::get('/forgot-password', function () {
//     return view('auth.forgot_password');
// })->name('forgot-password');

Route::get('/', function() {
    return redirect()->route('login.index');
});
Route::resource('login', LoginController::class);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::match(['get', 'post'], '/forgot-password', function(){
    return view('auth.forgot_password');
})->name('forgot-password');
Route::middleware('auth')->group(function (){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('order', OrderController::class);
    Route::resource('product', ProductController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('storage', StorageController::class);
    Route::resource('users', UsersController::class);
    Route::resource('user', UserController::class);
    Route::resource('brand', BrandController::class);
});
