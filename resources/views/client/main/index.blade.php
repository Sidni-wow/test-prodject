@extends('layouts.client')

@section('content')

    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">GoodFilm.TV</h1>
            <p class="lead text-muted">
                Для тебя, только лучшие фильмы !
            </p>
        </div>
    </section>

    <div class="album py-2 bg-light">
        <h2 class="text-center pb-5">Смотреть сегодня</h2>
        <div class="container">
            <div class="row">
                <?php /** @var App\Models\Film[] $films */ ?>
                @foreach($films as $film)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img class="card-img-top" src="{{ $film->image }}" alt="">
                            <div class="card-body">
                                <h5 class="card-title">{{ $film->title }}</h5>
                                <p class="card-text">
                                    {{ $film->description }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary"><a href="{{ route('client:films.show', $film) }}">Потробнее</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <h2 class="text-center pb-5">Смотреть скоро</h2>
        <div class="container">
            <div class="row">
                <?php /** @var App\Models\Film[] $watchSoonFilms */ ?>
                @foreach($watchSoonFilms as $film)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img class="card-img-top" src="{{ $film->image }}" alt="">
                            <div class="card-body">
                                <h5 class="card-title">{{ $film->title }}</h5>
                                <p class="card-text">
                                    <b>Будет доступен: {{ $film->watch_soon_at->toDateString() }}</b>
                                </p>
                                <p class="card-text">
                                    {{ $film->description }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary"><a href="{{ route('client:films.show', $film) }}">Потробнее</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
