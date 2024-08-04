@extends('layout.app')

@section('title', 'Feed')

@section('content')
    <div class="row">
        <div class="col-3">
            @include('layout.left-sidebar')
        </div>
        <div class="col-6">
            @include('shared.success-message')
            @include('shared.submit-idea')
            <hr>
            @forelse ($ideas as $idea)
                <div class="mt-3">
                    @include('ideas.idea-card')
                </div>
            @empty
                @if (request()->has('search'))
                    <p>No results found</p>
                @endif
            @endforelse
            <div class="mt-3">
                {{ $ideas->withQueryString()->links() }}
            </div>
        </div>
        <div class="col-3">
            @include('layout.search-bar')
        </div>
    </div>
@endsection
