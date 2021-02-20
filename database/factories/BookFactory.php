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
        $startedAt = null;
        $completedAt = null;

        if ($this->faker->boolean(75)) {
            $openLibraryDataRetrievedAt = $this->faker->dateTimeBetween('-2 years', 'yesterday');
        }

        if ($this->faker->boolean()) {
            $startedAt = $this->faker->dateTimeBetween('-2 years', '-1 month');

            if ($this->faker->boolean()) {
                $completedAt = $this->faker->dateTimeBetween($startedAt, 'yesterday');
            }
        }

        return [
            'isbn' => $this->faker->isbn13,
            'title' => implode(' ', $this->faker->words(rand(1, 4))),
            'author' => $this->faker->name,
            'started_at' => $startedAt,
            'completed_at' => $completedAt,
            'first_published_at' => $this->faker->dateTimeBetween('-2000 years', 'yesterday'),
            'openlibrary_data_retrieved_at' => $openLibraryDataRetrievedAt,
        ];
    }

    /**
     * Returned book will be in a state representing it has been populated via openlibrary.
     * This is indicated by a null openlibrary_data_retrieved_at
     * And relevant fields null
     *
     * @return \Database\Factories\BookFactory
     */
    public function unretrieved(): BookFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'isbn' => null,
                'first_sentence' => null,
                'openlibrary_data_retrieved_at' => null,
            ];
        });
    }

    /**
     * Returned book will be in a state representing it has been started.
     * This is indicated by a non-null started_at
     *
     * @return \Database\Factories\BookFactory
     */
    public function started(): BookFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'started_at' => $this->faker->dateTimeBetween('-2 years', '-1 month'),
                'completed_at' => null,
            ];
        });
    }

    /**
     * Returned book will be in a state representing it has been read.
     * This is indicated by a non-null competed_at
     * Which assumes a non-null started_at
     *
     * @return \Database\Factories\BookFactory
     */
    public function completed(): BookFactory
    {
        return $this->state(function (array $attributes) {
            $startedAt = $this->faker->dateTimeBetween('-2 years', '-1 month');

            return [
                'started_at' => $startedAt,
                'completed_at' => $this->faker->dateTimeBetween($startedAt, 'yesterday'),
            ];
        });
    }
}
