<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->string('slug');

            $table->string('isbn')->unique()->nullable();
            $table->string('title');
            $table->string('author')->nullable();
            $table->longText('first_sentence')->nullable();
            $table->date('first_published_at')->nullable();

            $table->decimal('read_order');

            $table->dateTime('added_at');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();

            $table->dateTime('openlibrary_data_retrieved_at')->nullable();
            $table->timestamps();

            $table->index('title');
            $table->index('author');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
