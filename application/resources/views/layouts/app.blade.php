<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Contrail+One&family=Open+Sans&display=swap" rel="stylesheet">

        <!-- Latest compiled and minified bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <!-- Styles -->
        <link rel="stylesheet" href="/css/brand.css" />

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="mywrap" style="margin-bottom:30px">
            <header class="navbar navbar-expand-lg navbar-light bg-light">
                <h2 class="logo-heading">VELOLOG</h2>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                    @auth
                    <li class="nav-item active">
                        <a class="nav-link" href="/home">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/bikes">Bikes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/settings">Settings</a>
                    </li>
                    @endauth
                    </ul>
                    @guest
                    <form class="form-inline my-2 my-lg-0" method="post" action="{{ route('login') }}">
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
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{Session::get('error')}}
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="container fluid">
                <div class="row flex-xl-nowrap">
                    <main class="col-md-12 col-xl-12 py-md-3 pl-md-3 bd-content" role="main">
                        @yield('content')
                    </main>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="fixed-bottom bg-light navbar mt-30" id="cookie-consent-container">
                <div class="d-flex justify-content-center w-100 mt-1 mb-1">
                    @include('cookieConsent::index')
                </div>
            </div>
        </div>
        <script src="/js/scripts.js"></script>
    </body>
</html>
