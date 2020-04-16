<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/favicon.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset(mix('js/app.js')) }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="background-color: #219ffe!important;">
            <div class="container">
                <div class="pageheader__logo">
                    <a href="{{ url('/') }}" class="logo" title="Київстар" aria-label="Посилання на головну сторінку">
                        <svg width="157" height="42" viewBox="0 0 210 52" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" xml:space="preserve">
                            <path class="logo__dots logo__dots--left" d="M111.9,11.1c0-2.7-2.2-4.8-4.9-4.8c-2.6,0-4.8,2.1-4.8,4.8c0,2.7,2.2,4.9,4.8,4.9  C109.7,16,111.9,13.9,111.9,11.1"></path>
                            <path class="logo__dots logo__dots--right" d="M124.4,11.1c0-2.7-2.2-4.8-4.9-4.8c-2.7,0-4.8,2.1-4.8,4.8c0,2.7,2.2,4.9,4.8,4.9  C122.2,16,124.4,13.9,124.4,11.1"></path>
                            <path class="logo__letter" d="M78,27.6l6.2-7.4c0.5-0.5,0.2-1.1-0.5-1.1H79c-0.4,0-0.9,0.2-1.2,0.6l-4.2,5.6V20c0-0.7-0.3-1-1-1h-3.4  c-0.7,0-1,0.3-1,1v17.2c0,0.7,0.3,1,1,1h3.4c0.7,0,1-0.3,1-1v-6.3l5.6,6.6c0.3,0.4,0.7,0.7,1.1,0.7h4.9c0.6,0,0.8-0.6,0.5-1.1  L78,27.6z"></path>
                            <path class="logo__letter" d="M115,19h-3.6c-0.7,0-1,0.3-1,1v17.2c0,0.7,0.3,1,1,1h3.6c0.7,0,1-0.3,1-1V20C115.9,19.4,115.7,19,115,19"></path>
                            <path class="logo__letter" d="M202.6,19l-7.9,0c-0.7,0-1,0.3-1,1v17.2c0,0.7,0.3,1,1,1h3.6c0.7,0,1-0.3,1-1v-4.6h3.1c4.3,0,7.6-2.4,7.6-6.6 C210,21.7,206.6,19,202.6,19 M202.2,28.4h-2.9v-4.9h2.8C205.9,23.5,206.2,28.4,202.2,28.4"></path>
                            <path class="logo__letter" d="M172.5,19h-13.9c-0.7,0-1,0.3-1,1v3.3c0,0.7,0.3,1,1,1h4.2v12.8c0,0.7,0.3,1,1,1h3.6c0.7,0,1-0.3,1-1V24.4h4.2  c0.7,0,1-0.3,1-1V20C173.5,19.3,173.1,19,172.5,19"></path>
                            <path class="logo__letter" d="M134.3,27.7c3.4-3.3,1.1-8.7-4.1-8.7l-8.8,0c-0.7,0-1,0.3-1,1v17.2c0,0.7,0.3,1,1,1l9.6,0  C137.9,38.2,139.7,30.3,134.3,27.7 M125.6,23.3h3.5c2.2,0,2.3,3,0,3h-3.5V23.3z M130.2,33.9h-4.6v-3.6h4.6 C133,30.3,133.2,33.9,130.2,33.9"></path>
                            <path class="logo__letter" d="M105.1,19l-4.4,0l-8,11V20c0-0.7-0.3-1-1-1h-3.3c-0.7,0-1,0.3-1,1v17.2c0,0.7,0.3,1,1,1h4.2l8.1-10.8v9.8  c0,0.7,0.3,1,1,1h3.3c0.7,0,1-0.3,1-1V20C106.1,19.3,105.8,19,105.1,19"></path>
                            <path class="logo__letter" d="M148.6,33.7c-2.9,0-5.2-2.3-5.2-5.1c0-2.8,2.3-5.1,5.1-5.1c1.6,0,3.3,0.7,4.2,1.5c0.4,0.4,0.7,0.6,1.3,0  l2.2-2.1c0.3-0.3,0.4-0.8-0.1-1.2c-2.1-1.9-4.4-3.2-7.5-3.2c-5.6,0-10.2,4.5-10.2,10.2c0,5.6,4.6,10.2,10.2,10.2  c3.1,0,5.5-1.3,7.5-3.2c0.5-0.5,0.4-1,0.1-1.2l-2.2-2.1c-0.6-0.6-0.9-0.4-1.3,0C151.8,33,150.2,33.7,148.6,33.7"></path>
                            <path class="logo__letter" d="M191.9,37.2l-6.6-17.5c-0.2-0.5-0.5-0.7-1.1-0.7h-4.4c-0.6,0-0.9,0.3-1.1,0.7l-6.6,17.5c-0.2,0.5,0.1,1,0.7,1h4  c0.3,0,0.7-0.3,0.8-0.6l0.9-2.6h0h6.9h0l0.9,2.6c0.1,0.3,0.5,0.6,0.8,0.6h4C191.8,38.2,192.1,37.8,191.9,37.2 M180.1,30.7L182,25h0  l1.9,5.6H180.1z"></path>
                            <path class="logo__letter" d="M27.2,19.8c-1.9,0-3.5-1.6-3.5-3.5V3.5c0-1.9,1.6-3.5,3.5-3.5c1.9,0,3.5,1.6,3.5,3.5v12.8  C30.7,18.3,29.1,19.8,27.2,19.8"></path>
                            <path class="logo__letter" d="M19,25.8c-0.6,1.8-2.6,2.8-4.4,2.2L2.4,24c-1.8-0.6-2.8-2.6-2.2-4.4c0.6-1.8,2.6-2.8,4.4-2.2l12.2,4  C18.6,22,19.6,23.9,19,25.8"></path>
                            <path class="logo__letter" d="M35.4,25.8c0.6,1.8,2.6,2.8,4.4,2.2l12.2-4c1.8-0.6,2.8-2.6,2.2-4.4c-0.6-1.8-2.6-2.8-4.4-2.2l-12.2,4  C35.8,22,34.8,23.9,35.4,25.8"></path>
                            <path class="logo__letter" d="M10.5,51.4c-1.6-1.1-1.9-3.3-0.8-4.9l7.5-10.4c1.1-1.6,3.3-1.9,4.9-0.8c1.6,1.1,1.9,3.3,0.8,4.9l-7.5,10.4  C14.2,52.2,12.1,52.6,10.5,51.4"></path>
                            <path class="logo__letter" d="M43.9,51.4c1.6-1.1,1.9-3.3,0.8-4.9l-7.5-10.4c-1.1-1.6-3.3-1.9-4.9-0.8c-1.6,1.1-1.9,3.3-0.8,4.9L39,50.7  C40.2,52.2,42.4,52.6,43.9,51.4"></path>
                        </svg>
                    </a>
                </div>
{{--                <a class="navbar-brand" href="{{ url('/') }}">--}}
{{--                    {{ config('app.name', 'Киевстар') }}--}}
{{--                </a>--}}
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
{{--                            @if (Route::has('register'))--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
{{--                                </li>--}}
{{--                            @endif--}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        @if (session()->has('database'))
            <footer>
                <div class="test-mode">
                    Test mode!
                </div>
            </footer>
        @endif
    </div>
</body>
</html>
