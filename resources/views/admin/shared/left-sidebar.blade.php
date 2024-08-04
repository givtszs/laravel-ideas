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
                <a class="{{ get_sidebar_link_style('admin.dashboard') }}" href="{{ route('admin.dashboard') }}">
                    <span>@lang('shared.dashboard')</span></a>
            </li>
            <li class="nav-item">
                <a class="{{ get_sidebar_link_style('admin.users') }}" href="{{ route('admin.users') }}">
                    <span>@lang('shared.users')</span></a>
            </li>
            <li class="nav-item">
                <a class="{{ get_sidebar_link_style('admin.ideas') }}" href="{{ route('admin.ideas') }}">
                    <span>@lang('shared.ideas')</span></a>
            </li>
            <li class="nav-item">
                <a class="{{ get_sidebar_link_style('admin.comments') }}" href="{{ route('admin.comments') }}">
                    <span>@lang('shared.comments')</span></a>
            </li>
        </ul>
    </div>
</div>
