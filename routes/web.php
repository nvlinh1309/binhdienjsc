<?php

use App\Http\Controllers\Order\BuyerController;
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
use App\Http\Controllers\User\Packaging\PackagingController;
use App\Http\Controllers\User\Packaging\WareHouseReceiptController;

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

    Route::resource('order-buyer', BuyerController::class);
    Route::name('order-buyer.')->prefix('order-buyer')->group(function () {
        Route::get('step1/{id}', [BuyerController::class, 'create_step1'])->name('step1');
        Route::post('step1/{id}', [BuyerController::class, 'store_step1'])->name('update.step1');
        Route::get('step2/{id}', [BuyerController::class, 'create_step2'])->name('step2');
        Route::get('confirm-step2/{id}', [BuyerController::class, 'store_step2'])->name('update.step2');
        Route::get('step3/{id}', [BuyerController::class, 'create_step3'])->name('step3');
        Route::get('step4/{id}', [BuyerController::class, 'create_step4'])->name('step4');

        Route::get('step6/{id}', [BuyerController::class, 'create_step6'])->name('step6');
        Route::post('step6/{id}', [BuyerController::class, 'store_step6'])->name('update.step6');

        Route::get('approve/{id}', [BuyerController::class, 'approve'])->name('approve');
        Route::get('reject/{id}', [BuyerController::class, 'reject'])->name('reject');

        Route::post('add-product/{id}', [BuyerController::class, 'add_product'])->name('add-product');
        Route::post('order-upload/{id}', [BuyerController::class, 'order_upload'])->name('order-upload');
        Route::get('purchaseOrderExport/{id}', [BuyerController::class, 'purchaseOrderExport'])->name('export-order');

    });



    Route::get('order-buyer/export/{id}', [OrderBuyerController::class, 'purchaseOrderExport'])->name('order-buyer.purchase-order-export');
    Route::get('order-buyer/warehouse_recript/export/{id}', [OrderBuyerController::class, 'wareHouseRecript'])->name('order-buyer.warehouse-recript-export');
    // Route::post('order-buyer/add-product/{id}', [OrderBuyerController::class, 'addProduct'])->name('order-buyer.add-product');
    Route::get('order-buyer/delete-product/{product_id}/{order_id}', [OrderBuyerController::class, 'deleteProduct'])->name('order-buyer.delete-product');
    Route::get('order-buyer/update-status/{order_id}/{status_id}', [OrderBuyerController::class, 'updateStatus'])->name('order-buyer.update-status');
    Route::post('order-buyer/add-warehouse_recript/{id}', [OrderBuyerController::class, 'addWareHouseRecript'])->name('order-buyer.add-warehouse_recript');
    Route::get('order-buyer/cancel', [OrderBuyerController::class, 'orderCancel'])->name('order-buyer.cancel');

    Route::resource('order-seller', OrderSellerController::class);
    Route::get('order-seller/export/{id}', [OrderSellerController::class, 'toDeliverExport'])->name('order-seller.to-deliver-export');
    Route::get('order-seller/invoice-request-form/export/{id}', [OrderSellerController::class, 'invoiceRequestForm'])->name('order-seller.invoice-request-form');
    Route::post('order-seller/add-product/{id}', [OrderSellerController::class, 'addProduct'])->name('order-seller.add-product');
    Route::get('order-seller/delete-product/{product_id}/{order_id}', [OrderSellerController::class, 'deleteProduct'])->name('order-seller.delete-product');
    Route::get('order-seller/update-status/{order_id}/{status_id}', [OrderSellerController::class, 'updateStatus'])->name('order-seller.update-status');
    Route::post('order-seller/add-warehouse_recript/{id}', [OrderSellerController::class, 'addWareHouseRecript'])->name('order-seller.add-warehouse_recript');
    Route::get('order-seller/cancel', [OrderSellerController::class, 'orderCancel'])->name('order-seller.cancel');



    Route::resource('packaging', PackagingController::class);


    Route::resource('warehouse-receipt', WareHouseReceiptController::class);
    Route::get('warehouse-receipt/export/{lot}', [WareHouseReceiptController::class, 'exportPDF'])->name('warehouse-receipt.export');

    Route::get('packaging/to-receive-create/{packaging_id}', [PackagingController::class, 'getInput'])->name('packaging.get-input');
    Route::post('packaging/to-receive-store/{packaging_id}', [PackagingController::class, 'postInput'])->name('packaging.post-input');
    Route::get('packaging/export-warehouse-receipt/{packaging_storage_id}', [PackagingController::class, 'exportPDF'])->name('packaging.export-warehouse-receipt');


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
