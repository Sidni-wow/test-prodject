<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\FilmRepository;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * @var FilmRepository
     */
    private $_repository;

    public function __construct(FilmRepository $repository)
    {
        $this->_repository = $repository;
    }

    public function index(Request $request)
    {
        $films = $this->getRepository()->getPublishedFilms();
        $watchSoonFilms = $this->getRepository()->getWatchSoonFilms();

        return view('client.main.index', compact('films', 'watchSoonFilms'));
    }

    /**
     * @return FilmRepository
     */
    private function getRepository(): FilmRepository
    {
        return $this->_repository;
    }
}
