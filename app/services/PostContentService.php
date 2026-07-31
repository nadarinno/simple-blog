<?php

namespace App\Services;

use Illuminate\Support\Str;

class PostContentService
{
    public function __construct(
        private readonly int $excerptLength = 180,
        private readonly int $wordsPerMinute = 200
    ) {
    }

    public function createExcerpt(string $body): string
    {
        $cleanBody = trim(strip_tags($body));

        return Str::limit($cleanBody, $this->excerptLength);
    }

    public function calculateReadingMinutes(string $body): int
    {
        $cleanBody = trim(strip_tags($body));

        $words = preg_split(
            '/\s+/u',
            $cleanBody,
            -1,
            PREG_SPLIT_NO_EMPTY
        );

        $wordCount = count($words ?: []);

        return max(
            1,
            (int) ceil($wordCount / $this->wordsPerMinute)
        );
    }
}