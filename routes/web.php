<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/{any?}/{other?}/{another?}', function () {
    return view('home');
});
