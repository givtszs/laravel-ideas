@extends('layout.app')

@if ($editing ?? false)
    @section('title', 'Edit profile')
@else
    @section('title', $user->name)
@endif

@section('content')
    <div class="row">
        <div class="col-3">
            @include('layout.left-sidebar')
        </div>
        <div class="col-6">
            @include('shared.success-message')

            @if ($editing ?? false)
                @include('users.user-card-edit')
            @else
                @include('users.user-card')
                @foreach ($user->ideas as $idea)
                    <div class="mt-3">
                        @include('ideas.idea-card')
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-3">
            @if (!($editing ?? false))
                @include('shared.top-users-box')
            @endif
        </div>
    </div>
@endsection
