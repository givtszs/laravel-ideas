@extends('layout.app')

@if ($editing ?? false)
    @section('title', 'Edit idea')
@else
    @section('title', 'View idea')
@endif


@section('content')
    <div class="row">
        <div class="col-3">
            @include('layout.left-sidebar')
        </div>
        <div class="col-6">
            @include('shared.success-message')
            @include('ideas.idea-card')
        </div>
        <div class="col-3">
            @include('layout.search-bar')
        </div>
    </div>
@endsection
