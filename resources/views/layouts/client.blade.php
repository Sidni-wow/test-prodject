
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Album example · Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/album/">

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com//docs/4.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.3/examples/album/album.css" rel="stylesheet">
</head>
<body>
<header>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">GoodFilm.TV</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            @can (\App\Models\User::ROLE_ADMIN)
                <a class="p-2 text-dark" href="{{ route('admin:main') }}">Admin</a>
            @endif

            @if (Route::has('login'))
                @auth
                    <span class="p-2 text-dark">{{ Auth::user()->name }}</span>
                @else
                    <a class="p-2 text-dark" href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a class="btn btn-outline-primary" href="{{ route('register') }}">Sign up</a>
                    @endif
                @endauth
            @endif
        </nav>
    </div>
</header>

<main role="main">

@yield('content')

</main>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script><script src="https://getbootstrap.com/docs/4.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script></body>
</html>
