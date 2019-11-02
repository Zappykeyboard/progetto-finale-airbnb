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
