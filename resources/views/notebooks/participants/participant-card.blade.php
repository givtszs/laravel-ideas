<div class="card d-flex flex-row align-items-center mb-2">
    <img class="avatar-sm rounded-circle ms-2 py-2" src="{{ $participant->getProfilePictureUrl() }}" alt="User profile picture"
        width="70px" />

    <div class="card-body d-flex flex-row justify-content-between align-items-center">
        <div class="d-flex flex-column">
            <h5 class="card-title">{{ $participant->name }}</h5>
            <h6 class="card-subtitle">{{ $participant->email }}</h6>
        </div>
        
        <div class="d-flex flex-wrap">
            <form class="me-2" action="" method="">
                <button class="btn btn-info">Make Moderator</button>
            </form>

            <form action="" method="">
                <button class="btn btn-danger">Remove</button>
            </form>
        </div>
    </div>

</div>
