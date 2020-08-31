<?php

use App\Http\Controllers\Admin\FilmController;
use Illuminate\Support\Facades\Route;

Route::get('films/{film}/up', [FilmController::class, 'up'])->name('films.up');
Route::get('films/{film}/down', [FilmController::class, 'down'])->name('films.down');

Route::resource('films', 'FilmController');
