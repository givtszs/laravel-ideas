@auth
    <h4>@lang('ideas.share_ideas')</h4>
    <div class="row">
        <form name="submit-idea-form" action="{{ route('ideas.store', ['notebookId' => $notebook->id ?? null ]) }}", method="post">
            @csrf
            <div class="mb-3">
                <textarea name="content" class="form-control" id="content" rows="3"></textarea>
                @error('content')
                    @include('shared.error-message-alert')
                @enderror
            </div>
            <div class="">
                <button type="submit" class="btn btn-dark">@lang('shared.share')</button>
            </div>
        </form>
    </div>
@endauth
