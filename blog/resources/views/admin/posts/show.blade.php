@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>

        <div class="row mt-5 mb-5">

            {{-- post content --}}
            <div class="{{ $post->cover ? 'col-md-6' : 'col' }}">
                {!! $post->content !!}
            </div>

            {{-- image posts --}}
            @if($post->cover)
                <div class="col-md-6">
                    <img class="img-fluid" src="{{ asset('storage/' . $post->cover) }}" alt="{{ $post->title }}">
                </div>
            @endif
        </div>

        <div class="mt-5">
            <strong class="badge bg-warning">CATEGORY:</strong>
            @if($post->category) {{ $post->category->name }} @else Uncategorized @endif
        </div>

        @if (!$post->tags->isEmpty())
        <strong class="badge bg-success mt-3">TAGS:</strong>
            @foreach($post->tags as $tag)
                {{ $tag->name }},
            @endforeach
        @else 
        <strong class="badge bg-danger mt-3">No tags in this post</strong>
        @endif

        <div class="mt-5">
            <a class="btn btn-primary" href="{{ route('admin.posts.edit', $post->id) }}">Edit</a>
        </div>
        <div class="mt-5">
            <a class="btn btn-success" href="{{ route('admin.posts.index') }}">Back to Posts</a>
        </div>
    </div>

@endsection