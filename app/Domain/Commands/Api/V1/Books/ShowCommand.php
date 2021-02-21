<?php

namespace App\Domain\Commands\Api\V1\Books;

use App\Models\Book;

class ShowCommand
{
    public function process(Book $book): array
    {
        if ($book->cover_image_uri) {
            $book->cover_image_src = asset('storage/'.$book->cover_image_uri);
        }

        return [
            'book' => $book,
        ];
    }
}