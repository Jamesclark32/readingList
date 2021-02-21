<?php

namespace Tests\Feature\Api\V1;

use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ShowBookTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        Event::fake([
            \App\Events\Models\Book\Saving::class,
        ]);
    }

    public function test_url_displays_book_from_database()
    {
        $books = Book::factory()->count(3)->create();

        foreach ($books as $book) {
            $response = $this->get(route('api.v1.books.show', [
                'book' => $book->slug,
            ]));

            $response->assertStatus(200);

            $response->assertSeeText($book->title);
            $response->assertSeeText($book->author);
        }
    }
}
