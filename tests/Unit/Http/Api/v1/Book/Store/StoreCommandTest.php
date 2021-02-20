<?php

namespace Tests\Unit\Http\Api\v1\Book\Store;

use App\Domain\Commands\Api\V1\Books\StoreCommand;
use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class StoreCommandTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        Event::fake([
            \App\Events\Models\Book\Saving::class,
        ]);
    }

    public function test_store_command_writes_book_to_database()
    {
        $command = new StoreCommand();

        $unsavedBookData = Book::factory()->make()->toArray();
        $command->process($unsavedBookData);

        $this->assertDatabaseHas('books', [
            'title' => $unsavedBookData['title'],
            'author' => $unsavedBookData['author'],
        ]);
    }
}
