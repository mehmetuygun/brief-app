<?php

namespace Tests\Feature;

use App\Actions\Library\RegisterAssociate;
use App\Enums\BookStatus;
use App\Models\Book;
use App\Models\Library;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BorrowBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_borrow_the_book(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var Library $library */
        $library = Library::factory()->create();
        /** @var Book $book */
        $book = Book::factory(['status' => BookStatus::AVAILABLE])
            ->for($library)
            ->create();

        RegisterAssociate::run([
            'user_id' => $user->id,
            'library_id' => $library->id
        ]);

        $data = [
            'user_id' => $user->id,
            'library_id' => $library->id,
            'book_id' => $book->id
        ];

        $this->actingAs($user)->post(route('books.borrow'), $data);

        /** @var Book $book */
        $book = Book::where('user_id', $user->id)
            ->where('library_id', $library->id)
            ->where('id', $book->id)
            ->first();

        $this->assertEquals(
            BookStatus::OUT_WITH_A_MEMBER->value,
            $book->status
        );
        $this->assertEquals($user->id, $book->user_id);
        $this->assertEquals($library->id, $book->library_id);

        /** @var Library $library */
        $library2 = Library::factory()->create();
        /** @var Book $book2 */
        $book2 = Book::factory(['status' => BookStatus::AVAILABLE])
            ->for($library2)
            ->create();

        $data = [
            'user_id' => $user->id,
            'library_id' => $library->id,
            'book_id' => $book2->id
        ];

        $this->actingAs($user)->post(route('books.borrow'), $data);

        /** @var Book $book */
        $book2 = Book::where('user_id', $user->id)
            ->where('library_id', $library->id)
            ->where('id', $book2->id)
            ->first();

        $this->assertNull($book2);
    }
}
