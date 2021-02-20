<?php

Route::post('books', \App\Http\Controllers\Api\V1\Books\StoreController::class)->name('books.store');
Route::delete('books/{book}', \App\Http\Controllers\Api\V1\Books\DestroyController::class)->name('books.destroy');