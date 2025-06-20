<?php
use App\Http\Controllers\UserController;
use App\Livewire\CustomLogin;
use Illuminate\Support\Facades\Route;

// Admin Login
Route::get('admin/login', CustomLogin::class);

// Home Page
Route::get('/home', function () {
    return view('home');
})->name('admin.home');

// Users - Moved entirely to controller handling
Route::get('/admin/users', [UserController::class, 'showUsers'])->name('admin.users');
Route::get('/admin/users/requests', [UserController::class, 'showUserRequests'])->name('admin.users.requests');
Route::get('/admin/users/view/{id}', [UserController::class, 'viewUser'])->name('admin.users.view');

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

Route::post('/logout', function () {
    session()->forget('user');
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/admin/login'); // Or your preferred redirect
})->name('logout');
