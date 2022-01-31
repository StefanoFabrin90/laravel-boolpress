@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>Welcome {{ Auth::user()->name }}</h1>
                    <h4>Your Ueser ID is: {{ Auth::id() }}</h4>
                </div>

                <div class="card-body">
                    <h2>What to do next?</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
