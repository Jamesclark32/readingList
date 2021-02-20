<?php

Route::name('v1.')->prefix('v1')->group(function () {
    include 'v1/books.php';
});