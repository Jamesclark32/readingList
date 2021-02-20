<?php

namespace App\Jobs\Models\Books;

use App\Models\Book;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

/**
 * Reindex the read_sequence column on the books table
 *
 * Class Resequence
 *
 * @package App\Jobs\Models\Books
 */
class Resequence
{
    use Dispatchable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     * @TODO: account for completed_at books likely not belonging in the read queue
     *
     * @return void
     */
    public function handle()
    {

        DB::statement('SET @new_books_read_sequence=0;');

        $query = <<<'SQL'
INSERT IGNORE INTO books (id, read_sequence)
SELECT books.id as id, @new_books_read_sequence:=@new_books_read_sequence+1 AS read_sequence FROM (
SELECT books.id
FROM books
ORDER BY books.read_sequence ASC, books.id ASC
) as books
ON DUPLICATE KEY UPDATE `read_sequence` = values(`read_sequence`);
SQL;

        DB::statement($query);
    }
}
