<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NetworkSystemController;
use App\Http\Controllers\TramSacController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Group routes for other pages but without 'auth' prefix in the URL
Route::get('/', [HomeController::class, 'Home'])->name('home');
Route::get('/tramsac', [HomeController::class, 'tramsac'])->name('tramsac');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'postLogin']);

Route::get('/sign', [UserController::class, 'sign'])->name('sign');
Route::post('/sign', [UserController::class, 'postSign']);

Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');

// Hiển thị thông tin cá nhân
Route::get('/profile', [UserController::class, 'showProfile'])->name('show.profile');
Route::put('/profile/update/{id}', [UserController::class, 'update'])->name('profile.update');

// routes/web.php
Route::get('/verify', [UserController::class, 'showVerifyForm'])->name('verify');
Route::post('/verify', [UserController::class, 'verifyToken']);

// lấy địa chỉ rồi hiển thị lên map
Route::get('/map', [TramSacController::class, 'map'])->name('map');

Route::view('/network_system', 'auth.network_system')->name('network_system');
// Đăng ký trở thành đối tác
Route::post('/register-partner', [NetworkSystemController::class, 'store'])->name('register.partner');
Route::view('/user_manual', 'auth.user_manual')->name('user_manual');


// trạm sạc
// Route::get('/tramsac', [TramSacController::class, 'index'])->name('index');
Route::get('/confirm-station/{token}', [TramSacController::class, 'confirm'])->name('tramsac.confirm');
Route::post('/tramsac/store', [TramSacController::class, 'store'])->name('tramsac.store');
// Route để hiển thị danh sách trạm sạc của người dùng
Route::get('/manage-stations', [TramSacController::class, 'index'])->name('tramsac.index');
// Route::get('/station/{id}/edit', [TramSacController::class, 'edit'])->name('station.edit');
// Route::put('/station/{id}', [TramSacController::class, 'update'])->name('station.update');
// Route::delete('/station/{id}', [TramSacController::class, 'destroy'])->name('station.destroy');

Route::get('/news', [HomeController::class, 'getNew'])->name('news');
Route::view('/details', 'auth.details')->name('details');
Route::view('/introduce', 'auth.introduce')->name('introduce');

Route::get('/logon', [AdminController::class, 'logon'])->name('logon');
Route::post('/logon', [AdminController::class, 'postLogon'])->name('admin.logon');
Route::get('/dashboard', [DashBoardController::class, 'logout'])->name('logout');

// Nhóm các route quản trị
Route::prefix('admin')->name('admin.')->group(function () {
  // Route cho trang dashboard
  Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');

  // Route cho trang đăng xuất
  Route::get('/logout', [DashBoardController::class, 'logout'])->name('logout');

  // Route cho trang tài khoản
  Route::get('/account', [App\Http\Controllers\Admin\UserController::class, 'account'])->name('account');
  Route::post('/account/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
  Route::get('/account/edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
  Route::put('/account/update/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
  Route::delete('/account/delete/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('delete');

  // web.php
  Route::post('/admin/users', [UserController::class, 'addUser'])->name('admin.addUser');

  // Route cho trang tin tức
  Route::get('/news', [DashBoardController::class, 'news'])->name('news');

  // Route cho trang phê duyệt
  Route::get('/approval', [DashBoardController::class, 'approval'])->name('approval');

  // Route cho trang trạm sạc
  Route::get('/charging', [DashBoardController::class, 'charging'])->name('charging');

  // Route cho trang email
  Route::get('/email', [DashBoardController::class, 'email'])->name('email');

  // Route cho trang đối tác
  Route::get('/cooperate', [App\Http\Controllers\Admin\NetworkSystemController::class, 'cooperate'])->name('cooperate');
  Route::post('/cooperate/store', [App\Http\Controllers\Admin\NetworkSystemController::class, 'store'])->name('store');
  Route::get('/cooperate/edit/{id}', [App\Http\Controllers\Admin\NetworkSystemController::class, 'edit'])->name('edit');
  Route::put('/cooperate/update/{id}', [App\Http\Controllers\Admin\NetworkSystemController::class, 'update'])->name('update');
  Route::delete('/cooperate/delete/{id}', [App\Http\Controllers\Admin\NetworkSystemController::class, 'destroy'])->name('delete');
});
