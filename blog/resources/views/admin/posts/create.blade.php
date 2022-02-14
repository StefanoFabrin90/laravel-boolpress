@extends('layouts.app')

@section('content')
    <div class="container">

        <h1 class="mb-5">Create new Post</h1>


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Title*</label>
                <input class="form-control" type="text" id="title" name="title" value="{{ old('title') }}">
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content*</label>
                <textarea class="form-control" rows="6" id="content" name="content">{{ old('content') }}</textarea>
                @error('content')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- category --}}
            <div class="mb-3">
                <label for="category_id">Category*</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">Uncategorized</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @if($category->id == old("category_id")) selected @endif>
                            {{$category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- tags --}}
            <div class="mb-3 mt-5">
                <h4>Tags</h4>

                @foreach($tags as $tag) 
                    <span class="d-inline-block mr-5">
                        <input type="checkbox" name="tags[]" id="tag{{ $loop->iteration }}" value="{{ $tag->id}}"
                        @if(in_array($tag->id, old('tags', []))) checked @endif>
                        <label for="tag{{ $loop->iteration }}">
                            {{$tag->name}}
                        </label>
                    </span>
                @endforeach
                @error('tags')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- cover --}}
            <div class="mb-3">
                <label class="form-label" for="cover"><strong>Post Image:</strong></label>
                <input class="form-control-file" type="file" name="cover" id="cover">
            </div>
            @error('cover')
                    <div class="text-danger">{{ $message }}</div>
            @enderror

            <button class="btn btn-danger mt-3" type="submit">Create a new Post</button>
        </form>

        <div class="mt-5">
            <a class="btn btn-success" href="{{ route('admin.posts.index') }}">Back to Posts</a>
        </div>
    </div>

@endsection