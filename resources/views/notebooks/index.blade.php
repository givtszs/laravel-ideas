@extends('layout.app')

@section('title', __('shared.notebooks'))

@section('content')
    <div class="row">
        <div class="col-3">
            @include('layout.left-sidebar')
        </div>

        <div class="col-6">
            @include('shared.success-message')

            <div class="d-flex align-items-center">
                <h4 class="me-3">@lang('notebooks.create')</h4>
                <form method="get" action="{{ route('notebooks.create') }}">
                    <button class="btn btn-primary">@lang('shared.create')</button>
                </form>
            </div>
            <hr>

            <h4>@lang('notebooks.explore')</h4>
            <p>Total notebooks: {{ $notebooks->count() }}</p>
            @forelse ($notebooks as $notebook)
                @include('notebooks.notebook-card')
            @empty
                <p>@lang('notebooks.no_notebooks')</p>
            @endforelse
        </div>

        <div class="col-3">
            @include('layout.search-bar')
        </div>
    </div>
@endsection
