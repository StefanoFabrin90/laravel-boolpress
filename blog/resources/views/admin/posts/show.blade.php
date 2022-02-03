@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>

        <div class="row mt-5">
            <div class="col-md-6">
                {!! $post->content !!}
            </div>
            <div class="col-md-6">
                <strong>image here</strong> 
            </div>
        </div>

        <div class="mt-5">
            <strong class="badge bg-warning">CATEGORY:</strong>
            @if($post->category) {{ $post->category->name }} @else Uncategorized @endif
            
        </div>

        <div class="mt-5">
            <a class="btn btn-primary" href="{{ route('admin.posts.edit', $post->id) }}">Edit</a>
        </div>
        <div class="mt-5">
            <a class="btn btn-success" href="{{ route('admin.posts.index') }}">Back to Posts</a>
        </div>
    </div>

@endsection