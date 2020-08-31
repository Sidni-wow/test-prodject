<?php

use App\Http\Controllers\Client\FilmController;
use Illuminate\Support\Facades\Route;

Route::get('films/{film}', [FilmController::class, 'show'])->name('films.show');
