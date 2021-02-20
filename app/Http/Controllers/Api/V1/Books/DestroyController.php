<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Domain\Commands\Api\V1\Books\DestroyCommand;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Book  $book
     * @param  DestroyCommand  $command
     *
     * @return JsonResponse
     */
    public function __invoke(Book $book, DestroyCommand $command): JsonResponse
    {
        $command->process($book);

        return response()->json([
            'book' => $book,
        ]);
    }
}
