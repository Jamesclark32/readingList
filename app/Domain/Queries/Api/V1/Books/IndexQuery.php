<?php

namespace App\Domain\Queries\Api\V1\Books;

use App\Models\Book;
use Illuminate\Support\Collection;

class IndexQuery
{
    public function getData(): Collection
    {
        return Book::query()
            ->orderBy('read_sequence', 'ASC')
            ->get();
    }
}