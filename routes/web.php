<?php

use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\UserController;
use App\Livewire\CustomLogin;
use Illuminate\Support\Facades\Route;

//Routes
Route::get('/', CustomLogin::class)->name('login');
Route::get('/admin/login', CustomLogin::class);
Route::get('/home', function () {return view('home');})->name('admin.home');
Route::post('/logout', function () {return redirect('/');})->name('logout');
Route::get('/admin/users', [UserController::class, 'showUsers'])->name('admin.users');
Route::get('/admin/users/requests', [UserController::class, 'showUserRequests'])->name('admin.users.requests');
Route::get('/admin/users/view/{id}', [UserController::class, 'viewUser'])->name('admin.users.view');
Route::get('/admin/user/add', [UserController::class, 'create'])->name('admin.user.add'); 
Route::post('/admin/users/save', [UserController::class, 'save'])->name('admin.user.save');
Route::get('/admin/users/view/{id}', [UserController::class, 'viewUser'])->name('admin.users.view');
Route::patch('/admin/users/approve/{id}', [UserController::class, 'approveUser'])->name('admin.users.approve');
Route::get('/admin/map-maker', function () {return view('map');})->name('admin.map');
Route::get('/admin/report', function () {return view('report');})->name('admin.report');Route::post('/logout', function () {session()->forget('user');session()->invalidate();session()->regenerateToken();return redirect('/admin/login');})->name('logout');
Route::get('/admin/master-data', [MasterDataController::class, 'showMasterData'])->name('admin.master-data');
Route::resource('categories', MasterDataController::class)->only(['index', 'edit', 'update', 'destroy']);

