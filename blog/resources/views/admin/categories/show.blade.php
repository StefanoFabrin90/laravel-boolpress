@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-5">Category: <strong>{{ $category->name }}</strong></h1>
        
        @foreach ($category->posts as $post)
            <ul>
                <li>
                    <a class="btn btn-danger" href="{{ route('admin.posts.show', $post->slug) }}">{{ $post->title }}</a>
                </li>
            </ul>
        @endforeach
    </div>

@endsection