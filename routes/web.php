<?php

use App\Livewire\CustomLogin;
use Illuminate\Support\Facades\Route;

Route::get('admin/login', CustomLogin::class);
Route::get('/home', function () {
    return view('home');
})->name('admin.home');

Route::get('/users', function () {
    return view('users');
})->name('admin.users');

Route::get('/master-data', function () {
    return view('master');
})->name('admin.master');

Route::get('/map-maker', function () {
    return view('map');
})->name('admin.map');

Route::get('/report', function () {
    return view('report');
})->name('admin.report');
