<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>BoolBnB</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
      <header>
        <div class="logo">
          <img src="air.jpg" alt="boolbnb logo">
        </div>
        <div class="nav">
          <ul class="navBar">

          </ul>
          @guest
            @if (Route::has('login'))
              <li><a href="{{ route('login') }}">Login</a></li>
            @endif

            @if (Route::has('register'))
                <li><a href="{{ route('register') }}">Register</a></li>
            @endif

            @else

              <li>{{ Auth::user()->lastname . ", " . Auth::user()->firstname }} </li>
              <li>  <a href="{{route('logout')}}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                Logout
              </a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @endguest
                </div>


      </header>
      <div class="container">
        @yield('content')
      </div>

        </div>
    </body>
</html>
