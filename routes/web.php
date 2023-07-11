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

    Route::name('stock-in.')->prefix('stock-in')->group(function() {
        Route::get('/', [OrderController::class, 'stockInIndex'])->name('index');
        Route::get('/create', [OrderController::class, 'stockInCreate'])->name('create');
        Route::post('/', [OrderController::class, 'stockInStore'])->name('store');
        Route::get('/{id}', [OrderController::class, 'stockInShow'])->name('show');
        Route::get('/{id}/edit', [OrderController::class, 'stockInEdit'])->name('edit');
        Route::post('/{id}', [OrderController::class, 'stockInEdit'])->name('update');
        Route::delete('/{id}', [OrderController::class, 'stockInDelete'])->name('destroy');
    });


    Route::resource('product', ProductController::class);
    Route::get('product-export', [ProductController::class, 'exportPDF'])->name('product.export');

    Route::resource('supplier', SupplierController::class);
    Route::get('supplier-export', [SupplierController::class, 'exportPDF'])->name('supplier.export');

    Route::resource('customer', CustomerController::class);
    Route::get('customer-export', [CustomerController::class, 'exportPDF'])->name('customer.export');

    Route::resource('user', UserController::class);

    Route::resource('brand', BrandController::class);
    Route::get('brand-export', [BrandController::class, 'exportPDF'])->name('brand.export');


    Route::resource('store', StorageController::class);
    Route::get('store-export', [StorageController::class, 'exportPDF'])->name('store.export');

    Route::resource('users', UsersController::class);
    Route::get('users-export', [UsersController::class, 'exportPDF'])->name('users.export');

    Route::get('role-and-permission', [UsersController::class, 'indexRaP'])->name('users.indexRaP');
    Route::get('role-and-permission/view/{id}', [UsersController::class, 'showRaP'])->name('users.showRaP');
});
