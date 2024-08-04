@extends('layout.app')

@section('title', 'Dashboard')

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
                    <p>@lang('ideas.no_results_found')</p>
                @else
                    <p>@lang('ideas.no_ideas_created')</p>
                @endif
            @endforelse
            <div class="mt-3">
                {{ $ideas->withQueryString()->links() }}
            </div>
        </div>
        <div class="col-3">
            @include('layout.search-bar')
            @include('shared.top-users-box')
        </div>
    </div>
@endsection
