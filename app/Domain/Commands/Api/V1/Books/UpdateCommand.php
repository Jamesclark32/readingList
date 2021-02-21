<?php

namespace App\Domain\Commands\Api\V1\Books;

use App\Jobs\Models\Books\Resequence;
use App\Models\Book;

class UpdateCommand
{
    public function process(Book $book, array $bookData): Book
    {
        $book->update($bookData);
        $book->fresh();

        dispatch(new Resequence());

        return $book;
    }
}