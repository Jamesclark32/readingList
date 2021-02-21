<?php

namespace App\Domain\Commands\Api\V1\Books;

use App\Models\Book;

class ShowCommand
{
    public function process(Book $book): array
    {
        $book->coverImage = asset('storage/book-covers/'.$book->slug.'.jpg');

        return [
            'book' => $book,
        ];
    }
}