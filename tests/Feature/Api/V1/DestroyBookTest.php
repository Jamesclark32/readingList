<?php

namespace Tests\Feature\Api\V1;

use App\Jobs\Models\Books\Resequence;
use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class DestroyBookTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        Event::fake([
            \App\Events\Models\Book\Saving::class,
        ]);
    }

    public function test_url_deletes_submitted_book_data_from_database()
    {
        $this->expectsJobs(Resequence::class);

        $bookData = Book::factory()->unretrieved()->create();

        $this->assertDatabaseHas('books', [
            'title' => $bookData->title,
            'author' => $bookData->author,
            'slug' => $bookData->slug,
        ]);

        $url = route('api.v1.books.destroy', ['book' => $bookData->slug]);

        $response = $this->delete($url);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('books', [
            'title' => $bookData->title,
            'author' => $bookData->author,
            'slug' => $bookData->slug,
        ]);
    }
}
