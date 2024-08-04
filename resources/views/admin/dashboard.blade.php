@extends('layout.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="row">
        <div class="col-3">
            @include('admin.shared.left-sidebar')
        </div>
        <div class="col">
            <h1>Admin Dashboard</h1>
            <div class="row mt-3">
                <div class="col-md-4">
                    @include('admin.shared.stats-widget', [
                        'title' => 'Users',
                        'icon' => 'fa-users',
                        'data' => $totalUsers
                    ])
                </div>
                <div class="col-md-4">
                    @include('admin.shared.stats-widget', [
                        'title' => 'Ideas',
                        'icon' => 'fa-lightbulb',
                        'data' => $totalIdeas
                    ])
                </div>
                <div class="col-md-4">
                    @include('admin.shared.stats-widget', [
                        'title' => 'Comments',
                        'icon' => 'fa-comments',
                        'data' => $totalComments
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
