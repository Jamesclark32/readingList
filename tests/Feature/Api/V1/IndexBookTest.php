<?php

namespace Tests\Feature\Api\V1;

use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class IndexBookTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        Event::fake([
            \App\Events\Models\Book\Saving::class,
        ]);
    }

    public function test_url_displays_books_from_database()
    {
        $books = Book::factory()->count(3)->create();

        $response = $this->get(route('api.v1.books.index'));

        $response->assertStatus(200);

        foreach ($books as $book) {
            $response->assertSeeText($book->title);
            $response->assertSeeText($book->author);
        }
    }
}
