<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Domain\Queries\Api\V1\Books\ShowQuery;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Book  $book
     * @param  ShowQuery  $command
     *
     * @return JsonResponse
     */
    public function __invoke(Book $book, ShowQuery $command): JsonResponse
    {
        $command->getData($book);

        return response()->json([
            'book' => $book,
        ]);
    }
}
