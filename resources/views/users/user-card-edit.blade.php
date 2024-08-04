<div class="card">
    <form action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('put')
        <div class="px-3 pt-4 pb-2">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img style="width:150px" class="me-3 avatar-sm rounded-circle"
                        src="{{ $user->getProfilePictureUrl() }}" alt="Avatar">
                    <div>
                        <label for="name" class="text-dark">@lang('profile.name')</label>
                        <input name="name" label="name" type="text" value="{{ $user->name }}"
                            class="form-control" />
                        @error('name')
                            @include('shared.error-message')
                        @enderror
                    </div>
                </div>
            </div>
            <input class="mt-3" name="profile_picture" type="file" accept="image/*" />
            <div class="px-2 mt-4">
                <h5 class="fs-5">@lang('profile.bio'):</h5>
                <div class="mb-3">
                    <textarea name="bio" class="form-control" rows="3">{{ $user->bio }}</textarea>
                    @error('bio')
                        @include('shared.error-message-alert')
                    @enderror
                </div>
                <button type="submit" class="btn btn-dark mb-3">@lang('shared.save')</button>
            </div>
        </div>
    </form>
</div>
