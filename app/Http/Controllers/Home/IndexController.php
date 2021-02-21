<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $viewData = [
            'urls' => [
                'books' => [
                    'index' => route('api.v1.books.index'),
                    'store' => route('api.v1.books.store'),
                ],
            ],
        ];
        return view('home.index')
            ->with($viewData);
    }
}
