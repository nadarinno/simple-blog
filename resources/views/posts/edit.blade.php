@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <div class="page-header">
        <h1>Edit Post</h1>
    </div>

    <div class="card">
        <form
            method="POST"
            action="{{ route('posts.update', $post) }}"
        >
            @csrf
            @method('PUT')

            @include('posts._form')
        </form>
    </div>
@endsection