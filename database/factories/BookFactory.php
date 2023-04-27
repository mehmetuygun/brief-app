<?php

namespace Database\Factories;

use App\Enums\BookStatus;
use App\Models\Book;
use App\Models\Library;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'status' => BookStatus::AVAILABLE
        ];
    }
}
