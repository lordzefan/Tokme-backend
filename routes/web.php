<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome', function () {
    return 'Selamat datang di Tokme Backend!';
});

Route::get('/dashboard', function () {
    return 'dashboard';
});
