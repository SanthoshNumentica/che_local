<?php

use App\Http\Controllers\UserController;
use App\Livewire\CustomLogin;
use Illuminate\Support\Facades\Route;

// Show login form at both `/` and `/admin/login`
Route::get('/', CustomLogin::class)->name('login');
Route::get('/admin/login', CustomLogin::class);


// Home Page
Route::get('/home', function () {
    return view('home');
})->name('admin.home');

// redirect('/admin/login')
Route::post('/logout', function () {
    return redirect('/');
})->name('logout');

// Users - Moved entirely to controller handling
Route::get('/admin/users', [UserController::class, 'showUsers'])->name('admin.users');
Route::get('/admin/users/requests', [UserController::class, 'showUserRequests'])->name('admin.users.requests');
Route::get('/admin/users/view/{id}', [UserController::class, 'viewUser'])->name('admin.users.view');
Route::patch('/admin/users/approve/{id}', [UserController::class, 'approveUser'])->name('admin.users.approve');

// Static views (if you want to keep these)
Route::get('/admin/master-data', function () {
    return view('master');
})->name('admin.master');

Route::get('/admin/map-maker', function () {
    return view('map');
})->name('admin.map');

Route::get('/admin/report', function () {
    return view('report');
})->name('admin.report');
