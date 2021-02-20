<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Domain\Commands\Api\V1\Books\StoreCommand;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Books\StoreRequest;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  StoreRequest  $request
     * @param  StoreCommand  $command
     *
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, StoreCommand $command): JsonResponse
    {
        $book = $command->process($request->validated());

        return response()->json([
            'book' => $book,
        ]);
    }
}
