<?php

use App\Http\Controllers\Client\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index'])->name('main');
