@error('content')
    @include('shared.error-message-alert')
@enderror

<div class="card">
    <div class="px-3 pt-4 pb-2">
        <div class="d-flex align-items-center justify-content-between">
            {{-- User --}}
            <div class="d-flex align-items-center">
                <img style="width:50px" class="me-2 avatar-sm rounded-circle"
                    src="{{ $idea->user->getProfilePictureUrl() }}" alt="Avatar">
                <div>
                    <h5 class="card-title mb-0"><a
                            href="{{ route('users.show', $idea->user_id) }}">{{ $idea->user->name }}</a></h5>
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="d-flex">
                <a class="me-2" href="{{ route('ideas.show', $idea->id) }}">@lang('ideas.view')</a>
                @auth
                    @can(['update', 'delete'], $idea)
                        @if (!($editing ?? false))
                            <a class="me-2" href="{{ route('ideas.edit', $idea->id) }}">@lang('shared.edit')</a>
                        @endif
                        <form action="{{ route('ideas.destroy', $idea->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm">X</button>
                        </form>
                    @endcan
                @endauth
            </div>
        </div>
    </div>

    <div class="card-body">
        {{-- Idea's content --}}
        @if (!($editing ?? false))
            <p class="fs-6 fw-light text-muted"> {{ $idea->content }} </p>
        @else
            <form action="{{ route('ideas.update', $idea->id) }}" , method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <textarea name="content" class="form-control" id="content" rows="3">{{ $idea->content }}</textarea>
                </div>
                <div class="">
                    <button type="submit" class="btn btn-dark">@lang('shared.update')</button>
                </div>
            </form>
        @endif

        {{-- Likes and creation time --}}
        <div class="d-flex justify-content-between">
            @auth
            {{-- Likes number --}}
                <div>
                    <form action="{{ route('ideas.like', $idea->id) }}" method="post">
                        @csrf
                        <button type="submit" class="fw-light nav-link fs-6">
                            @if (Auth::user()->doesLikeIdea($idea))
                                <span class="fas fa-heart me-1 mt-3"></span>
                            @else
                                <span class="far fa-heart me-1 mt-3"></span>
                            @endif
                            {{ $idea->likes_count }}
                        </button>
                    </form>
                </div>
            @endauth
            @guest
                <div>
                    <span class="far fa-heart me-1 mt-3"></span>
                    {{ $idea->likes()->count() }}
                </div>
            @endguest

            {{-- Created at --}}
            <div>
                <span class="fs-6 fw-light text-muted"> <span class="fas fa-clock"> </span>
                    {{ $idea->created_at->diffForHumans() }} </span>
            </div>
        </div>

        <div>
            @if (!($editing ?? false))
                {{-- Comment form --}}
                @auth
                    <form action="{{ route('ideas.comments.store', $idea->id) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <textarea name="content" class="fs-6 form-control" rows="1"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary btn-sm">@lang('ideas.post_comment')</button>
                        </div>
                    </form>
                @endauth
                <hr>

                {{-- Comments --}}
                @forelse ($idea->comments()->latest()->get() as $comment)
                    @include('ideas.comment')
                @empty
                    <p class="text-center mt-4">@lang('ideas.no_comments')</p>
                @endforelse
            @endif
        </div>
    </div>
</div>
