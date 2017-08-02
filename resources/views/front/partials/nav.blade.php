@inject('config' ,'App\Modules\Electrons\Config\Config')

<nav id="front-nav" class="navbar navbar-default navbar-{{ $nav }} navbar-static-top">
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
            <a class="navbar-brand" href="{{ url('/') }}">
                @if ($nav === 'white')
                    <img src="{{ asset('storage/images/web/logo_simple_sm.png') }}">
                @else
                    <img src="{{ asset('storage/images/web/logo_simple_white_sm.png') }}">
                @endif
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">

                <!-- Main Links -->

                <li class="{{ request()->is('about') ? 'active' : '' }}"><a href="{{ route('about') }}">Tentang</a></li>
                <li class="{{ request()->is('activities') ? 'active' : '' }}"><a href="{{ route('activities') }}">Acara</a></li>
                <li class="{{ request()->is('news*') ? 'active' : '' }}"><a href="{{ route('news') }}">Berita</a></li>
                <li class="{{ request()->is('faqs') ? 'active' : '' }}"><a href="{{ route('faqs') }}">FAQ</a></li>

                <!-- Authentication Links -->
                @if (Auth::guest())
                    @unless ($config->get('stage')['name'] === 'Pra-Pendaftaran' || $config->get('stage')['name'] === 'Paska Acara')
                        <li class="{{ request()->is('login') ? 'active' : '' }}"><a class="login-link" href="{{ route('login.form') }}">Daftar / Login</a></li>
                    @endunless
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <b>{{ Auth::user()->name }} <span class="caret"></span></b>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('dashboard') }}">Dasbor</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>