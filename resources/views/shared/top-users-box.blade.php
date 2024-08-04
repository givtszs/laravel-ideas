<div class="card">
    <div class="card-header pb-0 border-0">
        <h5 class="">@lang('shared.top_users')</h5>
    </div>
    <div class="card-body">
        @forelse ($topUsers as $user)
            @include('shared.top-user-card')
        @empty
            <p>@lang('shared.no_top_users')</p>
        @endforelse
    </div>
</div>
