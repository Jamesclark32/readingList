<?php

namespace App\Domain\Queries\Api\V1\Books;

use App\Models\Book;

class ShowQuery
{
    public function getData(Book $book): array
    {
        return [
            'book' => $this->transformBook($book),
        ];
    }

    protected function transformBook(Book $book): Book
    {
        if ($book->cover_image_uri) {
            $book->cover_image_src = asset('storage/'.$book->cover_image_uri);
        }

        return $book;
    }
}