<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Films\StoreRequest;
use App\Http\Requests\Admin\Films\UpdateRequest;
use App\Models\Film;
use App\Models\Product;
use App\Repositories\FilmRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    /**
     * @var FilmRepository
     */
    private $_repository;

    public function __construct(FilmRepository $repository)
    {
        $this->_repository = $repository;
    }

    public function index()
    {
        $films = $this->getRepository()->getAllFilms();

        return view('admin.films.index', compact('films'));
    }

    public function create()
    {
        return view('admin.films.create');
    }

    public function store(StoreRequest $request)
    {
        Film::create(array_merge($request->validated(), [
            'position' => Film::max('position') + 1,
        ]));

        return redirect()->route('admin:films.index');
    }

    public function show(Request $request, Film $film)
    {
        return view('admin.films.show', compact('film'));
    }

    public function edit(Request $request, Film $film)
    {
        return view('admin.films.edit', compact('film'));
    }

    public function update(UpdateRequest $request, Film $film)
    {
        $film->update($request->validated());

        return redirect()->route('admin:films.show', $film->id);
    }


    public function up(Request $request, Film $film)
    {
        $top = $film->getTop();

        if (is_null($top)) {
            return back();
        }

        $p = $top->position;
        $top->position = $film->position;
        $film->position = $p;

        DB::transaction(function () use ($film, $top) {
            $film->save();
            $top->save();
        });

        return back();
    }

    public function down(Request $request, Film $film)
    {
        $bottom = $film->getBottom();

        if (is_null($bottom)) {
            return back();
        }

        $p = $bottom->position;
        $bottom->position = $film->position;
        $film->position = $p;

        DB::transaction(function () use ($film, $bottom) {
            $film->save();
            $bottom->save();
        });

        return back();
    }

    public function destroy(Request $request, Film $film)
    {
        $film->delete();

        return redirect()->route('admin:films.index');
    }

    /**
     * @return FilmRepository
     */
    private function getRepository(): FilmRepository
    {
        return $this->_repository;
    }
}
