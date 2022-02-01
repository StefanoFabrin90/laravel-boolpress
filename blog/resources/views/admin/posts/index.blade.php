@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Blog Posts</h1>

        @if (session('delete'))
            <div class="alert alert-success">
                {{ session('delete') }} = deleted successfully.
            </div>
        @endif

        @if (($posts)->isEmpty())
            <p>No post found yet. <a href="{{ route('admin.posts.create') }}">Create a new post</a></p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TITLE</th>
                        <th colspan="3">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>
                                <a class="btn btn-warning" href="{{ route('admin.posts.show', $post->slug) }}">Show</a>
                            </td>
                            <td>
                                <a class="btn btn-secondary" href="{{ route('admin.posts.edit', $post->id) }}">Edit</a>
                            </td>
                            <td>
                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Delete" class="btn btn-danger">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        
        {{ $posts->links() }}
    </div>
@endsection