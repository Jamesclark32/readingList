<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Domain\Queries\Api\V1\Books\IndexQuery;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Domain\Queries\Api\V1\Books\IndexQuery  $query
     *
     * @return JsonResponse
     */
    public function __invoke(IndexQuery $query): JsonResponse
    {
        $viewData = $query->getData();

        return response()->json($viewData);
    }
}
