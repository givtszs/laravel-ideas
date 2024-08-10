@extends('layout.app')

@section('title', $notebook->name . ' - Participants')

@section('content')
    <div class="row">
        <div class="col-3">
            @include('layout.left-sidebar')
        </div>

        <div class="col-6">
            <div>
                <h4 class="">Participants - <span class="text-primary">{{ $notebook->users_count }}</span></h4>

                {{-- Show only for super-admin and notebook-admin --}}
                <p class="text-secondary-emphasis fs-6">Moderators: n/a</p>
            </div>
            <hr>

            @forelse ($participants as $participant)
                @include('notebooks.participants.participant-card')
            @empty
                <p>No participants</p>
            @endforelse
        </div>

        <div class="col-3">
            @include('layout.search-bar')
        </div>
    </div>
@endsection
