<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Latest compiled and minified bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <!-- Styles -->
        <link rel="stylesheet" href="css/brand.css" />

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </head>
    <body>
        <header class="navbar navbar-expand-lg navbar-light bg-light">
            <h2 class="logo-heading">VeloLog</h2>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/bikes">Bikes</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Settings
                    </a>
                </li>
                </ul>
                @guest
                <form class="form-inline my-2 my-lg-0" method="post" action="/login">
                @csrf
                    <input class="form-control mr-sm-2" type="email" placeholder="Email" aria-label="Email" value="{{ old('email') }}" name="email">
                    <input class="form-control mr-sm-2" type="password" placeholder="Password" aria-label="Password" name="password">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
                    <!-- fix this error display -->
                @if($errors->any())
                    <h4>{{ print_r($errors) }}</h4>
                @endif
                </form>
                @endguest
                @auth
                    <form class="form-inline my-2 my-lg-0" method="post" action="/logout">
                    @csrf
                    <button class="btn btn-outline-warn my-2 my-sm-0" type="submit">Logout</button>
                    </form>
                @endauth
            </div>
        </header>
        <div class="container fluid">
            <div class="row flex-xl-nowrap">
                <main class="col-md-12 col-xl-12 py-md-3 pl-md-3 bd-content" role="main">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
