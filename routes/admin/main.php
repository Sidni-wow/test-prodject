<?php

use App\Http\Controllers\Admin\MainController;
use Illuminate\Support\Facades\Route;

Route::get('main', [MainController::class, 'index'])->name('main');
