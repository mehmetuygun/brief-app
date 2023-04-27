<?php

namespace Tests\Feature;

use App\Actions\Library\BorrowBook;
use App\Actions\Library\RegisterAssociate;
use App\Models\Book;
use App\Models\Library;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_books()
    {
        $user = User::factory()->create();
        $library = Library::factory()->create();
        $books = Book::factory()
            ->for($library)
            ->count(250)
            ->create();

        RegisterAssociate::run([
            'library_id' => $library->id,
            'user_id' => $user->id
        ]);

        $count = 0;
        foreach ($books as $book) {
            if ($count % 10 == 0) {
                BorrowBook::run([
                    'user_id' => $user->id,
                    'library_id' => $library->id,
                    'book_id' => $book->id
                ]);
            }
            $count += 1;
        }

        $response = $this->actingAs($user)->get('books');

        $json = $response->json();

        $this->assertCount(100, $json['books']);
    }

    public function test_user_can_track_book()
    {
        $user = User::factory()->create();
        $library = Library::factory()->create();
        $book = Book::factory()
            ->for($library)
            ->create();

        RegisterAssociate::run([
            'library_id' => $library->id,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get(
            route('books.show', [
                'book' => $book->id
            ])
        );

        $json = $response->json();

        $this->assertIsArray($json);
    }
}
