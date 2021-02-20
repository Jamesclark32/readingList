<?php

namespace App\Domain\Commands\Api\V1\Books;

use App\Models\Book;

class StoreCommand
{
    public function process(array $bookData): Book
    {
        return Book::create($bookData);
    }
}