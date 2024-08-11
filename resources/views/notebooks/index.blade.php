@extends('layout.app')

@section('title', __('shared.notebooks'))

@section('content')
    <div class="row">
        <div class="col-3">
            @include('layout.left-sidebar')
        </div>

        <div class="col-6">
            @include('shared.success-message')

            {{-- Create a notebook --}}
            @auth
                <div class="d-flex align-items-center">
                    <h4 class="me-3">@lang('notebooks.create')</h4>
                    <form method="get" action="{{ route('notebooks.create') }}">
                        <button class="btn btn-primary">@lang('shared.create')</button>
                    </form>
                </div>
                <hr>
            @endauth

            {{-- User created notebooks --}}
            @auth
                @if (Auth::user()->notebooks()->count() > 0)
                    <h4>{{ Auth::user()->name }}'s notebooks</h4>

                    {{-- Show a list of user's created notebooks --}}
                    @foreach (Auth::user()->notebooks as $notebook)
                        @include('notebooks.notebook-card')
                    @endforeach
                    <hr>
                @endif
            @endauth

            {{-- Explore notebooks --}}
            <h4 class="mb-3">@lang('notebooks.explore')</h4>
            @forelse ($notebooks as $notebook)
                @include('notebooks.notebook-card')
            @empty
                <p>@lang('notebooks.no_notebooks')</p>
            @endforelse

            <div>
                {{ $notebooks->links() }}
            </div>
        </div>

        <div class="col-3">
            <!-- TODO: Search notebooks instead of ideas -->
            @include('layout.search-bar')
        </div>
    </div>
@endsection
