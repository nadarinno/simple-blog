@extends('layouts.app')

@section('title', 'Deleted Posts')

@section('content')
    <div class="page-header">
        <h1>Deleted Posts</h1>

        <a
            href="{{ route('posts.index') }}"
            class="button button-secondary"
        >
            Back to Posts
        </a>
    </div>

    @forelse($posts as $post)
        <article class="card">
            <h2>{{ $post->title }}</h2>

            <div class="meta">
                Category:
                {{ $post->category->name }}

                |

                Deleted:
                {{ $post->deleted_at->format('M d, Y h:i A') }}
            </div>

            <p>{{ $post->excerpt }}</p>

            @if($post->tags->isNotEmpty())
                <div>
                    @foreach($post->tags as $tag)
                        <span class="tag">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            @endif

            <div class="actions">
                <form
                    method="POST"
                    action="{{ route(
                        'posts.restore',
                        $post->id
                    ) }}"
                >
                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="button button-success"
                    >
                        Restore Post
                    </button>
                </form>

                <form
                    method="POST"
                    action="{{ route(
                        'posts.force-delete',
                        $post->id
                    ) }}"
                    onsubmit="return confirm(
                        'This post will be permanently deleted. This action cannot be undone. Are you sure?'
                    )"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="button button-danger"
                    >
                        Delete Permanently
                    </button>
                </form>
            </div>
        </article>
    @empty
        <div class="card empty-message">
            The trash is currently empty.
        </div>
    @endforelse

    {{ $posts->links() }}
@endsection