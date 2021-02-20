<?php

Route::post('books', \App\Http\Controllers\Api\V1\Books\StoreController::class)->name('books.store');