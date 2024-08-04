@extends('layout.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="row">
        <div class="col-3">
            @include('admin.shared.left-sidebar')
        </div>
        <div class="col">
            <h1>Comments</h1>
            <table class="table table-striped table-hover mt-3">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Idea ID</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Content</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td><a href="{{ route('ideas.show', $comment->idea_id) }}">{{ $comment->idea_id }}</a></td>
                            <td><a href="{{ route('users.show', $comment->user_id) }}">{{ $comment->user_id }}</a></td>
                            <td>{{ $comment->content }}</td>
                            <td>{{ $comment->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
@endsection
