<div class="card mb-3">
    <div class="card-header pb-0 border-0">
        <h5 class="">@lang('shared.search')</h5>
    </div>
    <div class="card-body">
        <!-- TODO: Rewrite searching logic -->
        <form action="{{ in_array(Route::currentRouteName(), ['dashboard', 'feed']) ? route(Route::currentRouteName()) : route('dashboard') }}" method="get">
            <input name="search" value="{{ request('search', '') }}" placeholder="..." class="form-control w-100" type="text" />
            <button class="btn btn-dark mt-2">@lang('shared.search')</button>
        </form>
    </div>
</div>
