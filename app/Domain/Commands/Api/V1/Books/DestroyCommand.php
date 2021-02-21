<?php

namespace App\Domain\Commands\Api\V1\Books;

use App\Jobs\Models\Books\Resequence;
use App\Models\Book;

class DestroyCommand
{
    public function process(Book $book): void
    {
        $book->delete();

        //Resequence the collection of books
        dispatch(new Resequence());
    }
}