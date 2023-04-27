<?php

namespace App\Rules;

use App\Enums\BookStatus;
use App\Models\Book;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class BookIsAvailable implements DataAwareRule, ValidationRule
{
    /**
     * All the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail
    ): void {
        $book = Book::whereId($value)->first();

        if ($book and $book->status != BookStatus::AVAILABLE->value) {
            $fail('The book is not available.');
        }

        if ($book->library_id != $this->data['library_id']) {
            $fail('This book does not belong to library');
        }
    }
}
