<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostDetail;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect([
            'Technology',
            'Programming',
            'Artificial Intelligence',
            'Web Development',
        ])->map(function (string $name): Category {
            return Category::create([
                'name' => $name,
            ]);
        });

        $tags = collect([
            'Laravel',
            'PHP',
            'Web Development',
            'Artificial Intelligence',
            'Database',
            'Programming',
        ])->map(function (string $name): Tag {
            return Tag::create([
                'name' => $name,
            ]);
        });

        Post::factory()
            ->count(20)
            ->make()
            ->each(function (Post $post) use ($categories, $tags): void {
                $post->category_id = $categories->random()->id;
                $post->save();

                PostDetail::factory()
                    ->for($post)
                    ->create();

                $selectedTagIds = $tags
                    ->random(random_int(1, 3))
                    ->pluck('id')
                    ->all();

                $post->tags()->sync($selectedTagIds);
            });
    }
}