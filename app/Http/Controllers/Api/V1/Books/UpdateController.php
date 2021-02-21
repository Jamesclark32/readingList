<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Domain\Commands\Api\V1\Books\UpdateCommand;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Books\UpdateRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Api\V1\Books\UpdateRequest  $request
     * @param  Book  $book
     * @param  UpdateCommand  $command
     *
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, Book $book, UpdateCommand $command): JsonResponse
    {
        $command->process($book, $request->validated());

        return response()->json([
            'book' => $book,
        ]);
    }
}
