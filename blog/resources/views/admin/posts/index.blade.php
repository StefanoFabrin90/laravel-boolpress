@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Blog Posts</h1>

        @if (($posts)->isEmpty())
            <p>No post found yet. <a href="{{ route('admin.posts.create') }}">Create a new post</a></p>
        @else
            <h3>table</h3>
        @endif
    </div>

@endsection