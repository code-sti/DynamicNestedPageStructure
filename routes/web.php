<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('app'); // The view that contains your main Vue app.
})->where('any', '.*');
