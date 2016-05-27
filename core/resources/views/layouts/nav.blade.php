<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">dig</a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <!-- Authentication Links -->
                @if ( Auth::check() )
                    <li class="{{ Request::is('home') ? 'active' : '' }}"><a href="{{ url('/home') }}">Dashboard</a></li>
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if ( Auth::guest() )
                    <li class="{{ Request::is('login') ? 'active' : '' }}"><a href="{{ url('/login') }}">Se connecter</a></li>
                    <li class="{{ Request::is('register') ? 'active' : '' }}"><a href="{{ url('/register') }}">S'inscrire</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li class="{{ Request::is('profile/*') ? 'active' : '' }}"><a href="{{ route('profile', Auth::user()) }}">Mon compte</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ url('/logout') }}"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Se déconnecter</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
