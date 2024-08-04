@extends('layout.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="row">
        <div class="col-3">
            @include('admin.shared.left-sidebar')
        </div>
        <div class="col">
            <h1>Ideas</h1>
            <table class="table table-striped table-hover mt-3">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Content</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ideas as $idea)
                        <tr>
                            <td>{{ $idea->id }}</td>
                            <td><a href="{{ route('users.show', $idea->user_id) }}">{{ $idea->user_id }}</a></td>
                            <td>{{ $idea->content }}</td>
                            <td>{{ $idea->created_at }}</td>
                            <td>
                                <a href="{{ route('ideas.show', $idea->id) }}">View</a>
                                <a href="{{ route('ideas.edit', $idea->id) }}">Edit</a>
                                <form action="{{ route('ideas.destroy', $idea->id) }}" method="post">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-link">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $ideas->links() }}
            </div>
        </div>
    </div>
@endsection
