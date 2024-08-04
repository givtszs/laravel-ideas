<div class="hstack gap-2 mb-3">
    <div class="avatar">
        <img class="avatar-img rounded-circle" style="width:50px" src="{{ $user->getProfilePictureUrl() }}"
            alt="Profile picture" />
    </div>
    <div class="overflow-hidden">
        <a class="h6 mb-0" href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
        <p class="mb-0 small text-truncate">{{ $user->email }}</p>
    </div>
</div>
