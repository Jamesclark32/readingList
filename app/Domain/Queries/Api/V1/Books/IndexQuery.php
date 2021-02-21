<?php

namespace App\Domain\Queries\Api\V1\Books;

use App\Models\Book;

class IndexQuery
{
    public function getData(): array
    {
        return [
            'books' => $this->getBooks(),
        ];
    }

    protected function getBooks()
    {
        return Book::query()
            ->orderBy('read_sequence', 'ASC')
            ->get()
            ->transform(function ($book) {
                return $this->transformBook($book);
            });
    }

    /**
     * Add the appropriate url for a show call.
     * Add the appropriate url for a destroy call.
     *
     * @param $book
     *
     * @return mixed
     */
    protected function transformBook($book)
    {
        $book->destroyUrl = route('api.v1.books.destroy', [
            'book' => $book->slug,
        ]);

        $book->showUrl = route('api.v1.books.show', [
            'book' => $book->slug,
        ]);

        return $book;
    }
}