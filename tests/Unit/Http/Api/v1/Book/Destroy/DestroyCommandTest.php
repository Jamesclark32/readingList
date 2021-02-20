<?php

namespace Tests\Unit\Http\Api\v1\Book\Destroy;

use App\Domain\Commands\Api\V1\Books\DestroyCommand;
use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class DestroyCommandTest extends TestCase
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
        $command = new DestroyCommand();

        $savedBook = Book::factory()->create();

        $this->assertDatabaseHas('books', [
            'title' => $savedBook['title'],
            'author' => $savedBook['author'],
        ]);

        $command->process($savedBook);

        $this->assertDatabaseMissing('books', [
            'title' => $savedBook['title'],
            'author' => $savedBook['author'],
        ]);
    }
}
