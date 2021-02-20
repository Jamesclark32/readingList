<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $openLibraryDataRetrievedAt = null;
        if (rand(1, 10) > 3) {
            $openLibraryDataRetrievedAt = $this->faker->dateTimeBetween('-2 years', 'yesterday');
        }

        return [
            'isbn' => $this->faker->isbn13,
            'title' => implode(' ', $this->faker->words(rand(1, 4))),
            'author' => $this->faker->name,
            'first_sentence' => $this->faker->sentence,
            'first_published_at' => $this->faker->dateTimeBetween('-2000 years', 'yesterday'),
            'openlibrary_data_retrieved_at' => $openLibraryDataRetrievedAt,
        ];
    }
}
