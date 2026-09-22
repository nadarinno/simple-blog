<div class="form-group">
    <label for="title">Post Title</label>

    <input
        id="title"
        type="text"
        name="title"
        value="{{ old('title', $post?->title) }}"
        placeholder="Enter the post title"
        required
    >
</div>

<div class="form-group">
    <label for="category_id">Category</label>

    <select
        id="category_id"
        name="category_id"
        required
    >
        <option value="">Select a category</option>

        @foreach($categories as $category)
            <option
                value="{{ $category->id }}"
                @selected(
                    old(
                        'category_id',
                        $post?->category_id
                    ) == $category->id
                )
            >
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="excerpt">Post Excerpt</label>

    <textarea
        id="excerpt"
        name="excerpt"
        placeholder="Enter a short description of the post"
    >{{ old('excerpt', $post?->excerpt) }}</textarea>

    <small>
        Leave this field empty to generate an excerpt automatically.
    </small>
</div>

<div class="form-group">
    <label for="body">Post Content</label>

    <textarea
        id="body"
        name="body"
        placeholder="Write the post content"
        required
    >{{ old('body', $post?->body) }}</textarea>
</div>

<div class="form-group">
    <label for="source">Post Source</label>

    <input
        id="source"
        type="text"
        name="source"
        value="{{ old(
            'source',
            $post?->detail?->source
        ) }}"
        placeholder="Enter the source or URL"
    >
</div>

<div class="form-group">
    <label>Tags</label>

    <div class="checkboxes">
        @foreach($tags as $tag)
            <label>
                <input
                    type="checkbox"
                    name="tag_ids[]"
                    value="{{ $tag->id }}"
                    @checked(
                        in_array(
                            $tag->id,
                            old(
                                'tag_ids',
                                $post
                                    ? $post->tags->pluck('id')->all()
                                    : []
                            )
                        )
                    )
                >

                {{ $tag->name }}
            </label>
        @endforeach
    </div>
</div>

<div class="form-group">
    <input
        type="hidden"
        name="is_published"
        value="0"
    >

    <label class="publish-label">
        <input
            type="checkbox"
            name="is_published"
            value="1"
            @checked(
                old(
                    'is_published',
                    $post?->is_published ?? true
                )
            )
        >

        Publish this post
    </label>
</div>

<button type="submit" class="button">
    Save Post
</button>

<a
    href="{{ route('posts.index') }}"
    class="button button-secondary"
>
    Cancel
</a>