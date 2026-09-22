@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <article class="card">
        <h1>{{ $post->title }}</h1>

        <div class="meta">
            Category:
            {{ $post->category->name }}

            |

            Published:
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

        @if($post->tags->isNotEmpty())
            <div>
                @foreach($post->tags as $tag)
                    <span class="tag">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif

        @if($post->excerpt)
            <p>
                <strong>{{ $post->excerpt }}</strong>
            </p>
        @endif

        <div class="post-body">
            {{ $post->body }}
        </div>

        @if($post->detail?->source)
            <hr>

            <p>
                <strong>Source:</strong>
                {{ $post->detail->source }}
            </p>
        @endif

        <div class="actions">
            <a
                href="{{ route('posts.edit', $post) }}"
                class="button button-secondary"
            >
                Edit Post
            </a>

            <a
                href="{{ route('posts.index') }}"
                class="button"
            >
                Back to Posts
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
                    Delete Post
                </button>
            </form>
        </div>
    </article>
@endsection