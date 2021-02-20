<?php

namespace App\Domain\Commands\Api\V1\Books;

use App\Models\Book;

class DestroyCommand
{
    public function process(Book $book): void
    {
        $book->delete();
    }
}