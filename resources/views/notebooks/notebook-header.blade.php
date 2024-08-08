<div class="card">
    <img class="card-img-top object-fit-cover" height="180px" src="{{ $notebook->getCoverUrl() }}" alt="Notebook cover" />

    <div class="card-body">
        <h5 class="card-title text-center">{{ $notebook->name }}</h5>
        <p class="card-subtitle text-center text-body-secondary">{{ $notebook->description }}</p>

        <div class="d-flex justify-content-between mt-4">
            <div class="d-flex">
                <div class="d-flex align-items-center">
                    <span class="fas fa-users me-1"></span>
                    <p class="mb-0">Participants: {{ $notebook->users_count }}</p>
                </div>

                <div class="d-flex align-items-center ms-3">
                    <span class="fas fa-lightbulb me-1"></span>
                    <p class="mb-0">Ideas: {{ $notebook->ideas_count }}</p>
                </div>
            </div>

            @auth
                @if (Auth::user()->joinedNotebook($notebook))
                @else
                    <form action="{{ route('notebooks.join', $notebook->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-danger float-end">
                            <span class="fas fa-plus me-1"></span>
                            Join
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</div>
