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
use App\Http\Controllers\User\Auth\ForgotPasswordController;
use App\Http\Controllers\User\Order\OrderBuyerController;
use App\Http\Controllers\User\Order\OrderSellerController;

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

Route::get('/', function () {
    return redirect()->route('login.index');
});
Route::resource('login', LoginController::class);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forgot-password');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
// Route::match(['get', 'post'], '/forgot-password', function(){
//     return view('auth.forgot_password');
// })->name('forgot-password');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('order', OrderController::class);

    Route::resource('order-buyer', OrderBuyerController::class);
    Route::get('order-buyer/export/{id}', [OrderBuyerController::class, 'purchaseOrderExport'])->name('order-buyer.purchase-order-export');
    // Route::get('product/create/step-2/{id}', [OrderBuyerController::class, 'createStep2'])->name('order-buyer.create-step-2');

    Route::resource('order-seller', OrderSellerController::class);
    Route::post('/get-products', [OrderController::class, 'getProductBasedWh'])->name('order.get.product');
    Route::name('order.')->prefix('order')->group(function () {
        // Route::get('/show/{id}', [OrderController::class, 'showOrder'])->name('show');
        Route::get('delivery-export/{id}', [OrderController::class, 'exportDeliveryPDF'])->name('export');
        Route::get('export/delivery-list-export', [OrderController::class, 'exportListDeliveryPDF'])->name('list.delivery');
        Route::get('invoice-export/{id}', [OrderController::class, 'exportInvoicePDF'])->name('invoice.export');
        Route::get('notification-order/{id}', [OrderController::class, 'notificationOrderPDF'])->name('notification.order');
        Route::delete('/delete/{id}', [OrderController::class, 'deliveryDelete'])->name('destroy');
    });

    Route::name('stock-in.')->prefix('stock-in')->group(function () {
        Route::get('/show/{id}', [OrderController::class, 'showInstock'])->name('price');
        Route::post('/set-price', [OrderController::class, 'setPriceStore'])->name('price.store');
        Route::get('/', [OrderController::class, 'stockInIndex'])->name('index');
        Route::get('/create', [OrderController::class, 'stockInCreate'])->name('create');
        Route::post('/', [OrderController::class, 'stockInStore'])->name('store');
        // Route::get('/{id}', [OrderController::class, 'stockInShow'])->name('show');
        Route::get('/{id}/edit', [OrderController::class, 'stockInEdit'])->name('edit');
        Route::post('/{id}', [OrderController::class, 'stockInUpdate'])->name('update');
        Route::delete('/{id}', [OrderController::class, 'stockInDelete'])->name('destroy');
        Route::get('stock-list-export', [OrderController::class, 'exportListStockPDF'])->name('list.export');

    });

    Route::get('instock-export/{id}', [OrderController::class, 'exportStockPDF'])->name('instock.export');
    Route::get('instock-invoice/{id}', [OrderController::class, 'invoiceStockPDF'])->name('instock.invoice');
    // Route::post('/changePassword', [App\Http\Controllers\HomeController::class, 'changePasswordPost'])->name('changePasswordPost');

    Route::resource('product', ProductController::class);
    Route::get('product/history/{id}', [ProductController::class, 'getProductHis'])->name('product.history');
    Route::post('product/set-price', [ProductController::class, 'setPriceStore'])->name('product.price.store');
    Route::get('product-export', [ProductController::class, 'exportPDF'])->name('product.export');

    Route::resource('supplier', SupplierController::class);
    Route::get('supplier-export', [SupplierController::class, 'exportPDF'])->name('supplier.export');
    Route::get('supplier/history/{id}', [SupplierController::class, 'getSupplierHis'])->name('supplier.history');

    Route::resource('customer', CustomerController::class);
    Route::get('customer-export', [CustomerController::class, 'exportPDF'])->name('customer.export');

    Route::resource('user', UserController::class);

    Route::post('changePassword', [UserController::class, 'changePasswordPost'])->name('changePasswordPost');

    Route::resource('brand', BrandController::class);
    Route::get('brand-export', [BrandController::class, 'exportPDF'])->name('brand.export');
    Route::get('brand/history/{id}', [BrandController::class, 'getBrandHis'])->name('brand.history');

    Route::resource('store', StorageController::class);
    Route::get('store-export', [StorageController::class, 'exportPDF'])->name('store.export');
    Route::get('store/history/{id}', [StorageController::class, 'getStorageHis'])->name('store.history');

    Route::resource('users', UsersController::class);
    Route::get('users-export', [UsersController::class, 'exportPDF'])->name('users.export');

    Route::group(['middleware' => ['can:role-view']], function () {
        Route::get('role-and-permission', [UsersController::class, 'indexRaP'])->name('users.indexRaP');
        Route::get('role-and-permission/view/{id}', [UsersController::class, 'showRaP'])->name('users.showRaP');
    });
    Route::group(['middleware' => ['can:role-edit']], function () {
        Route::post('set-permission', [UsersController::class, 'setPermission'])->name('users.role.set');
    });

});
