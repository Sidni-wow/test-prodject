<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Films\ShowRequest;
use App\Models\Film;

class FilmController extends Controller
{
    public function show(ShowRequest $request, Film $film)
    {
        return view('client.films.show', compact('film'));
    }
}
