<div class="card d-flex flex-row align-items-center mb-2">
    <img class="avatar-sm rounded-circle ms-2 py-2" src="{{ $participant->getProfilePictureUrl() }}"
        alt="User profile picture" width="70px" />

    <div class="card-body d-flex flex-row justify-content-between align-items-center">
        <div class="d-flex flex-column">
            <h5 class="card-title">{{ $participant->name }}</h5>
            <h6 class="card-subtitle">{{ $participant->email }}</h6>
        </div>

        <div class="d-flex flex-wrap">
            @if ($notebook->getUserRole()?->hasPermissionTo('role_grant_notebook_moderator') && $notebook->getUserRole($participant) == null)
                <form class="me-2"
                    action="{{ route('notebooks.participants.make-moderator', ['notebook' => $notebook->id, 'participant' => $participant->id]) }}"
                    method="post">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-info">Make Moderator</button>
                </form>
            @endif

            @if ($notebook->getUserRole()?->hasPermissionTo('user_remove_from_notebook'))
                <form
                    action="{{ route('notebooks.participants.remove', ['notebook' => $notebook->id, 'participant' => $participant->id]) }}"
                    method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Remove</button>
                </form>
            @endif
        </div>
    </div>

</div>
