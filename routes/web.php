<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NetworkSystemController;
use App\Http\Controllers\TramSacController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\ChargingPortController;
use App\Http\Controllers\Admin\ChargingStationController;
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
Route::get('/station', [HomeController::class, 'tramsac'])->name('tramsac');
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
Route::post('/confirm-station', [TramSacController::class, 'confirmAjax'])->name('tramsac.confirm');
Route::get('/confirm-station/{token}', [TramSacController::class, 'confirm'])->name('tramsac.confirm');
Route::post('/tramsac/store', [TramSacController::class, 'store'])->name('tramsac.store');
// Route::get('/tramsac', [TramSacController::class, 'showCar'])->name('tramsac.create');


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
  Route::post('/account/add', [App\Http\Controllers\Admin\UserController::class, 'addUser'])->name('addUser');
  Route::get('/account/editUser/{id}', [App\Http\Controllers\Admin\UserController::class, 'editUser'])->name('editUser');
  Route::put('/account/updateUser/{id}', [App\Http\Controllers\Admin\UserController::class, 'updateUser'])->name('updateUser');
  Route::delete('/account/deleteUser/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroyUser'])->name('deleteUser');
  Route::put('/account/resetPassword/{id}', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('resetPassword');

  // web.php
  Route::post('/admin/users', [UserController::class, 'addUser'])->name('admin.addUser');

  // Route cho trang tin tức
  Route::get('/news', [NewsController::class, 'news'])->name('news');
  Route::post('/news/addNews', [NewsController::class, 'addNews'])->name('addNews');
  Route::get('/news/editNews/{id}', [NewsController::class, 'editNews'])->name('editNews');
  Route::put('/news/updateNews/{id}', [NewsController::class, 'updateNews'])->name('updateNews');
  Route::delete('/news/deleteNews/{id}', [NewsController::class, 'deleteNews'])->name('deleteNews');

// Route cho trang trạm sạc
Route::get('/chargingStation', [ChargingStationController::class, 'chargingStation'])->name('chargingStation'); // Hiển thị danh sách trạm sạc
Route::post('/chargingStation/addchargingStation', [ChargingStationController::class, 'addChargingStation'])->name('addChargingStation'); // Thêm trạm sạc mới
Route::put('/chargingStation/updatechargingStation/{id}', [ChargingStationController::class, 'updateChargingStation'])->name('updateChargingStation'); // Cập nhật trạm sạc
Route::delete('/chargingStation/deletechargingStation/{id}', [ChargingStationController::class, 'destroychargingStation'])->name('deleteChargingStation'); // Xóa trạm sạc

  // Route cho trang cổng sạc
  Route::get('/chargingPort', [ChargingPortController::class, 'chargingPorts'])->name('chargingPort'); // Sửa từ DashBoardController thành ChargingPortController
  Route::post('/chargingPort', [ChargingPortController::class, 'addPort'])->name('addChargingPort'); // Sửa tên route để không bị trùng
  Route::put('/chargingPort/{id}', [ChargingPortController::class, 'updatePort'])->name('updateChargingPort');
  Route::delete('/chargingPort/{id}', [ChargingPortController::class, 'destroyPort'])->name('deleteChargingPort');


  // Route cho trang đối tác
  Route::get('/cooperate', [App\Http\Controllers\Admin\NetworkSystemController::class, 'cooperate'])->name('cooperate');
  Route::post('/cooperate/store', [App\Http\Controllers\Admin\NetworkSystemController::class, 'store'])->name('store');
  Route::get('/cooperate/edit/{id}', [App\Http\Controllers\Admin\NetworkSystemController::class, 'edit'])->name('edit');
  Route::put('/cooperate/update/{id}', [App\Http\Controllers\Admin\NetworkSystemController::class, 'update'])->name('update');
  Route::delete('/cooperate/delete/{id}', [App\Http\Controllers\Admin\NetworkSystemController::class, 'destroy'])->name('delete');
});