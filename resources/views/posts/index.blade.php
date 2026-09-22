@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
    <div class="page-header">
        <h1>All Posts</h1>

        <a
            href="{{ route('posts.create') }}"
            class="button"
        >
            Create Post
        </a>
    </div>

    @forelse($posts as $post)
        <article class="card">
            <h2>{{ $post->title }}</h2>

            <div class="meta">
                Category:
                {{ $post->category->name }}

                |

                Created:
                {{ $post->created_at->format('M d, Y') }}

                @if($post->detail)
                    |

                    Reading time:
                    {{ $post->detail->reading_minutes }}
                    {{ $post->detail->reading_minutes === 1
                        ? 'minute'
                        : 'minutes' }}
                @endif

                |

                Status:
                {{ $post->is_published
                    ? 'Published'
                    : 'Draft' }}
            </div>

            <p>
                {{ $post->excerpt }}
            </p>

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
                <a
                    href="{{ route('posts.show', $post) }}"
                    class="button"
                >
                    Read Post
                </a>

                <a
                    href="{{ route('posts.edit', $post) }}"
                    class="button button-secondary"
                >
                    Edit
                </a>

                <form
                    method="POST"
                    action="{{ route('posts.destroy', $post) }}"
                    onsubmit="return confirm(
                        'Are you sure you want to move this post to the trash?'
                    )"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="button button-danger"
                    >
                        Delete
                    </button>
                </form>
            </div>
        </article>
    @empty
        <div class="card empty-message">
            No posts are currently available.
        </div>
    @endforelse
@if($posts->hasPages())
    <div class="pagination">
        @if($posts->onFirstPage())
            <span class="pagination-disabled">
                Previous
            </span>
        @else
            <a href="{{ $posts->previousPageUrl() }}">
                Previous
            </a>
        @endif

        <span class="pagination-info">
            Page {{ $posts->currentPage() }}
            of {{ $posts->lastPage() }}
        </span>

        @if($posts->hasMorePages())
            <a href="{{ $posts->nextPageUrl() }}">
                Next
            </a>
        @else
            <span class="pagination-disabled">
                Next
            </span>
        @endif
    </div>
@endif
@endsection