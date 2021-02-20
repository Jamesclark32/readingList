<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Domain\Commands\Api\V1\Books\StoreCommand;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Books\StoreRequest;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Api\V1\Books\StoreRequest  $request
     * @param  \App\Domain\Commands\Api\V1\Books\StoreCommand  $command
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $request, StoreCommand $command)
    {
        $book = $command->process($request->validated());
    }
}
