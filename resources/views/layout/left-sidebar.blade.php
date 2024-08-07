<div class="card overflow-hidden">
    <div class="card-body pt-3">
        <ul class="nav nav-link-secondary flex-column fw-bold gap-2">
            @php
                if (!function_exists('get_sidebar_link_style')) {
                    function get_sidebar_link_style(string $routeName)
                    {
                        $linkStyle = Route::is($routeName) ? 'text-white bg-primary rounded' : '';
                        $linkStyle .= ' nav-link';
                        return $linkStyle;
                    }
                }
            @endphp
            <li class="nav-item">
                <a class="{{ get_sidebar_link_style('dashboard') }}" href="{{ route('dashboard') }}">
                    <span>@lang('shared.home')</span></a>
            </li>
            @auth
                <li class="nav-item">
                    <a class="{{ get_sidebar_link_style('feed') }}" href="{{ route('feed') }}">
                        @lang('shared.feed')
                    </a>
                </li>
            @endauth
            <li class="nav-item">
                <a class="{{ get_sidebar_link_style('notebooks.index') }}" href="{{ route('notebooks.index') }}">
                    @lang('shared.notebooks')
                </a>
            </li>
        </ul>
    </div>
    <div class="card-footer text-center py-2">
        <a class="btn btn-link btn-sm" href="{{ !is_null(Auth::user()) ? route('profile') : route('login') }}">
            @lang('shared.view_profile')
        </a>
    </div>
</div>
