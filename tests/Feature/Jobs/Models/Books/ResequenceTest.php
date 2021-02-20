<?php

namespace Tests\Feature\Jobs\Models\Books;

use App\Jobs\Models\Books\Resequence;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ResequenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_books_correctly_resequenced()
    {
        $books = Book::factory()
            ->count(10)
            ->state(function (array $attributes) {
                return [
                    'read_sequence' => mt_rand(1, 3000),
                ];
            })
            ->create();

        $originalData = [];
        foreach ($books as $book) {
            $originalData[$book->read_sequence] = $book->title;
        }

        ksort($originalData);

        dispatch(new Resequence());

        $updatedData = DB::table('books')
            ->select([
                'title',
                'read_sequence',
            ])
            ->get()
            ->sortBy('read_sequence')
            ->keyBy('read_sequence')
            ->transform(function ($value) {
                return $value->title;
            })
            ->toArray();

        $this->assertSame(array_values($originalData), array_values($updatedData));
    }
}