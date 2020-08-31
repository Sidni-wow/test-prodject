@extends('adminlte::page')

@section('title', 'Films')

@section('content_header')
    <h1>Films</h1>
@stop

@section('content')

    <div class="pb-3">
        <a href="{{ route('admin:films.create') }}" class="btn btn-primary">
            Create film
        </a>
    </div>

    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th>Title</th>
                <th>description</th>
                <th>image</th>
                <th>Is published</th>
                <th>Is watch soon</th>
                <th>Position</th>
                <th>Active</th>
            </tr>
        </thead>
        <tbody>
            <?php /** @var App\Models\Film $film  */ ?>
            @foreach($films as $film)
                <tr>
                    <th scope="row">{{ $film->id }}</th>
                    <td>{{ $film->title }}</td>
                    <td>{{ $film->description }}</td>
                    <td><img src="{{ $film->image }}" alt="" height="50px" width="50px"></td>
                    <td>{{ $film->published_at }}</td>
                    <td>{{ $film->watch_soon_at }}</td>
                    <td>
                        <?php $prev = null; ?>

                        <a href="{{ route('admin:films.up', $film->id) }}"
                           class="btn btn-sm btn-outline-secondary @if($loop->first) invisible @endif">
                            up
                        </a>

                        <a href="{{ route('admin:films.down', $film->id) }}"
                           class="btn btn-sm btn-outline-secondary
                                                    @if($loop->last) invisible @endif
                               "
                        >
                            down
                        </a>
                    </td>
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
            @endforeach
        </tbody>
    </table>

    {{ $films->links() }}
@stop
