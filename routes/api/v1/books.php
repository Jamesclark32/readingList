<?php

Route::get('books', \App\Http\Controllers\Api\V1\Books\IndexController::class)->name('books.index');
Route::get('books/{book}', \App\Http\Controllers\Api\V1\Books\ShowController::class)->name('books.show');
Route::post('books', \App\Http\Controllers\Api\V1\Books\StoreController::class)->name('books.store');
Route::delete('books/{book}', \App\Http\Controllers\Api\V1\Books\DestroyController::class)->name('books.destroy');