<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\PostContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        private readonly PostContentService $contentService
    ) {
    }

    
    public function index(): View
    {
        $posts = Post::query()
            ->with([
                'category',
                'tags',
                'detail',
            ])
            ->latest()
            ->paginate(8);

        return view('posts.index', compact('posts'));
    }

   
    public function create(): View
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        $tags = Tag::query()
            ->orderBy('name')
            ->get();

        return view(
            'posts.create',
            compact('categories', 'tags')
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePost($request);

        DB::transaction(function () use ($request, $validated): void {
            $tagIds = $validated['tag_ids'] ?? [];
            $source = $validated['source'] ?? null;

            unset(
                $validated['tag_ids'],
                $validated['source']
            );

            $validated['is_published'] =
                $request->boolean('is_published');

            if (empty($validated['excerpt'])) {
                $validated['excerpt'] = $this->contentService
                    ->createExcerpt($validated['body']);
            }

            $post = Post::create($validated);

            $post->detail()->create([
                'source' => $source,
                'reading_minutes' => $this->contentService
                    ->calculateReadingMinutes($post->body),
            ]);

            $post->tags()->sync($tagIds);
        });

        return redirect()
            ->route('posts.index')
            ->with('success', 'The post was created successfully.');
    }

    public function show(Post $post): View
    {
        $post->load([
            'category',
            'tags',
            'detail',
        ]);

        return view('posts.show', compact('post'));
    }

   
    public function edit(Post $post): View
    {
        $post->load([
            'tags',
            'detail',
        ]);

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        $tags = Tag::query()
            ->orderBy('name')
            ->get();

        return view(
            'posts.edit',
            compact('post', 'categories', 'tags')
        );
    }

   
    public function update(
        Request $request,
        Post $post
    ): RedirectResponse {
        $validated = $this->validatePost($request);

        DB::transaction(
            function () use ($request, $validated, $post): void {
                $tagIds = $validated['tag_ids'] ?? [];
                $source = $validated['source'] ?? null;

                unset(
                    $validated['tag_ids'],
                    $validated['source']
                );

                $validated['is_published'] =
                    $request->boolean('is_published');

                if (empty($validated['excerpt'])) {
                    $validated['excerpt'] = $this->contentService
                        ->createExcerpt($validated['body']);
                }

                $post->update($validated);

                $post->detail()->updateOrCreate(
                    [
                        'post_id' => $post->id,
                    ],
                    [
                        'source' => $source,
                        'reading_minutes' => $this->contentService
                            ->calculateReadingMinutes($post->body),
                    ]
                );

                $post->tags()->sync($tagIds);
            }
        );

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'The post was updated successfully.');
    }

    
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with(
                'success',
                'The post was moved to the trash successfully.'
            );
    }

   
    public function trash(): View
    {
        $posts = Post::onlyTrashed()
            ->with([
                'category',
                'tags',
                'detail',
            ])
            ->latest('deleted_at')
            ->paginate(8);

        return view('posts.trash', compact('posts'));
    }

    
    public function restore(int $id): RedirectResponse
    {
        $post = Post::onlyTrashed()
            ->findOrFail($id);

        $post->restore();

        return redirect()
            ->route('posts.trash')
            ->with('success', 'The post was restored successfully.');
    }

    
    public function forceDelete(int $id): RedirectResponse
    {
        $post = Post::onlyTrashed()
            ->findOrFail($id);

        $post->forceDelete();

        return redirect()
            ->route('posts.trash')
            ->with(
                'success',
                'The post was permanently deleted.'
            );
    }

    
    private function validatePost(Request $request): array
    {
        return $request->validate(
            [
                'title' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'excerpt' => [
                    'nullable',
                    'string',
                    'max:500',
                ],

                'body' => [
                    'required',
                    'string',
                    'min:10',
                ],

                'category_id' => [
                    'required',
                    'integer',
                    'exists:categories,id',
                ],

                'tag_ids' => [
                    'nullable',
                    'array',
                ],

                'tag_ids.*' => [
                    'integer',
                    'exists:tags,id',
                ],

                'source' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'is_published' => [
                    'nullable',
                    'boolean',
                ],
            ],
            [
                'title.required' => 'The post title is required.',
                'title.max' => 'The title cannot exceed 255 characters.',

                'excerpt.max' =>
                    'The excerpt cannot exceed 500 characters.',

                'body.required' => 'The post content is required.',
                'body.min' =>
                    'The post content must contain at least 10 characters.',

                'category_id.required' =>
                    'Please select a category.',

                'category_id.exists' =>
                    'The selected category does not exist.',

                'tag_ids.array' =>
                    'The selected tags must be provided as a list.',

                'tag_ids.*.exists' =>
                    'One or more selected tags do not exist.',

                'source.max' =>
                    'The source cannot exceed 255 characters.',

                'is_published.boolean' =>
                    'The publication status must be true or false.',
            ]
        );
    }
}