<div class="card">
    <div class="px-3 pt-4 pb-2">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img style="width:150px" class="me-3 avatar-sm rounded-circle" src="{{ $user->getProfilePictureUrl() }}"
                    alt="Avatar">
                <div>
                    <h3 class="card-title mb-0">
                        <a href="#S">{{ $user->name }}</a>
                    </h3>
                    <span class="fs-6 text-muted">{{ $user->email }}</span>
                </div>
            </div>
            @can('update', $user)
                <div>
                    <a href="{{ route('users.edit', $user->id) }}">@lang('shared.edit')</a>
                </div>
            @endcan
        </div>
        <div class="px-2 mt-4">
            <h5 class="fs-5">@lang('profile.bio'): </h5>
            <p class="fs-6 fw-light">{{ $user->bio }}</p>
            <div class="d-flex justify-content-start">
                <a href="#" class="fw-light nav-link fs-6 me-3">
                    <span class="fas fa-user me-1"></span>
                    {{ trans_choice('profile.number_of_followers', $user->followers()->count()) }}
                </a>
                <a href="#" class="fw-light nav-link fs-6 me-3">
                    <span class="fas fa-brain me-1"></span>
                    {{ $user->ideas()->count() }}
                </a>
                <a href="#" class="fw-light nav-link fs-6">
                    <span class="fas fa-comment me-1"></span>
                    {{ $user->comments()->count() }}
                </a>
            </div>
            @auth
                @if (Auth::user()->isNot($user))
                    <div class="mt-3">
                        @if (Auth::user()->follows($user))
                            <form action="{{ route('users.unfollow', $user->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm mb-2">@lang('profile.unfollow')</button>
                            </form>
                        @else
                            <form action="{{ route('users.follow', $user->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm mb-2">@lang('profile.follow')</button>
                            </form>
                        @endif
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>
<hr>
