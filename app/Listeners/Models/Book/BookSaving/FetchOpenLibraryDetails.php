<?php

namespace App\Listeners\Models\Book\BookSaving;

use App\Events\Models\Book\Saving;
use App\Helpers\OpenLibrary;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class FetchOpenLibraryDetails
{
    protected OpenLibrary $openLibraryHelper;

    /**
     * Create the event listener.
     *
     * @param  \App\Helpers\OpenLibrary  $openLibraryHelper
     */
    public function __construct(OpenLibrary $openLibraryHelper)
    {
        $this->openLibraryHelper = $openLibraryHelper;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Models\Book\Saving  $savingBookEvent
     *
     * @return void
     */
    public function handle(Saving $savingBookEvent)
    {
        $book = $savingBookEvent->getBook();

        if (empty($book->isbn)) {
            $data = $this->openLibraryHelper->search($book->title, $book->author);
            $book->isbn = Arr::get($data, 'isbn');
            $book->first_published_at = Arr::get($data, 'first_published_at');
            $book->save();

            $this->openLibraryHelper->fetchCover($book->isbn, $book->slug);
        }
    }
}
