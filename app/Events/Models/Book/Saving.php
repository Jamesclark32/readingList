<?php

namespace App\Events\Models\Book;

use App\Models\Book;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Saving
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected Book $book;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Book  $book
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * @return \App\Models\Book
     */
    public function getBook(): Book
    {
        return $this->book;
    }
}
