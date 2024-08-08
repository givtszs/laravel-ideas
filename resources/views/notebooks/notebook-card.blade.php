<div class="card d-flex flex-row mb-4">
    <div class="w-25 flex-shrink-0">
        <img width="100%" height="100%" class="object-fit-cover rounded" src="{{ $notebook->getCoverUrl() }}" alt="Notebook cover" />
    </div>

    <div class="card-body">
        {{-- Title and participants number --}}
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title"> <a class="link-underline link-underline-opacity-0 link-underline-opacity-100-hover" href="#"> {{ $notebook->name }} </a></h5>
            <div class="d-flex">
                <span class="fas fa-users me-1"></span>
                <p class="card-subtitle">n/a</p>
            </div>
        </div>

        <p class="card-text">{{ $notebook->description }}</p>

        <form action="#" method="">
            <button class="btn btn-primary float-end">
                <span class="fas fa-plus me-1"></span>
                Join
            </button>
        </form>
    </div>
</div>
