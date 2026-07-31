@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <div class="page-header">
        <h1>Create a New Post</h1>
    </div>

    <div class="card">
        <form
            method="POST"
            action="{{ route('posts.store') }}"
        >
            @csrf

            @include('posts._form', [
                'post' => null,
            ])
        </form>
    </div>
@endsection