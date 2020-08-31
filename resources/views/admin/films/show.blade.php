@extends('adminlte::page')

@section('title', 'Show film:' . $film->title)

@section('content_header')
    <h1>Show film: {{ $film->title }}</h1>
@stop

@section('content')

    <div class="pb-3">
        <a href="{{ route('admin:films.index') }}" class="btn btn-primary">
            Films
        </a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th>Title</th>
                <th>description</th>
                <th>image</th>
                <th>Is published</th>
                <th>Is watch soon</th>
                <th>Active</th>
            </tr>
        </thead>
        <tbody>
            <?php /** @var App\Models\Film $film  */ ?>
            <tr>
                <th scope="row">{{ $film->id }}</th>
                <td>{{ $film->title }}</td>
                <td>{{ $film->description }}</td>
                <td><img src="{{ $film->image }}" alt="" height="50px" width="50px"></td>
                <td>{{ $film->published_at }}</td>
                <td>{{ $film->watch_soon_at }}</td>
                <td class="text-right">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle btn-info btn-sm" data-toggle="dropdown"><span>Active</span>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{ route('admin:films.show', $film->id) }}"
                               class="dropdown-item">Show</a>
                            <a href="{{ route('admin:films.edit', $film->id) }}"
                               class="dropdown-item">Edit</a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item"
                               href="{{ route('admin:films.destroy', $film->id) }}"
                               onclick="event.preventDefault(); confirm('Delete film: {{ addslashes($film->title) }}?') ? document.getElementById('delete-form{{$film->id}}').submit() : false ;">
                                {{ __('Delete') }}
                            </a>

                            <form id="delete-form{{$film->id}}"
                                  action="{{ route('admin:films.destroy', $film->id) }}" method="POST"
                                  style="display: none;">
                                @method('delete')
                                @csrf
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
@stop
