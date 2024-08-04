<nav class="navbar navbar-expand-lg bg-dark border-bottom border-bottom-dark ticky-top bg-body-tertiary"
    data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand fw-light" href="/"><span class="fas fa-brain me-1">
            </span>{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                @php
                    if (!function_exists('get_nav_link_style')) {
                        function get_nav_link_style(string $routeName)
                        {
                            $linkStyle = Route::is($routeName) ? 'active' : '';
                            $linkStyle .= ' nav-link';
                            return $linkStyle;
                        }
                    }

                    if (!function_exists('activate_locale')) {
                        function activate_locale(string $locale)
                        {
                            return $locale == App::currentLocale() ? ' active' : '';
                        }
                    }
                @endphp
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button"
                        data-bs-toggle="dropdown">{{ strtoupper(App::currentLocale()) }}</a>
                    <ul class="dropdown-menu">
                        @foreach (config('app.languages') as $locale => $language)
                            <li><a class="dropdown-item {{ activate_locale($locale) }}" href="{{ route('change_language', $locale) }}">{{ $language }} </a></li>
                        @endforeach
                    </ul>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="{{ get_nav_link_style('login') }}" aria-current="page"
                            href="/login">@lang('auth.login')</a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ get_nav_link_style('register') }}" href="/register">@lang('auth.register')</a>
                    </li>
                @endguest
                @auth
                    @if (Auth::user()->is_admin)
                        <li class="nav-item">
                            <a class="{{ get_nav_link_style('admin.dashboard') }}"
                                href="{{ route('admin.dashboard') }}">@lang('shared.admin')</a>
                        </li>
                    @endif
                    <li>
                        <img style="width:35px" class="avatar-sm rounded-circle"
                            src="{{ Auth::user()->getProfilePictureUrl() }}" alt="Avatar">
                    </li>
                    <li class="nav-item">
                        <a class="{{ get_nav_link_style('profile') }}"
                            href="{{ route('profile') }}">{{ Auth::user()->name }}</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-text fw-semibold">@lang('auth.logout')</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
