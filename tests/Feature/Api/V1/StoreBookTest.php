<?php

namespace Tests\Feature\Api\V1;

use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StoreBookTest extends TestCase
{
    use DatabaseMigrations;

    public function test_url_writes_submitted_book_data_to_database()
    {
        $unsavedBookData = Book::factory()->make()->toArray();

        $response = $this->post(route('api.v1.books.store'), [
            'title' => $unsavedBookData['title'],
            'author' => $unsavedBookData['author'],
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('books', [
            'title' => $unsavedBookData['title'],
            'author' => $unsavedBookData['author'],
        ]);
    }

    public function test_url_returns__on_invalid_data()
    {
        $response = $this->post(route('api.v1.books.store'), [
            'title' => null,
        ]);

        $response->assertStatus(422);
    }
}
