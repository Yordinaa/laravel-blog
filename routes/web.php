<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', function () {
    return "Web routes are working!";
});

Route::get('/test', function () {
    return "This is a test route!";
});