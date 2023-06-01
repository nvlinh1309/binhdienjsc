<?php
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\DashboardController;
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
});