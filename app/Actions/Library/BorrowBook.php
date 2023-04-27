<?php

namespace App\Actions\Library;

use App\Enums\BookStatus;
use App\Models\Associate;
use App\Models\Book;
use App\Rules\BookIsAvailable;
use App\Rules\LibraryHasUser;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class BorrowBook
{
    use AsAction;

    public function rules(): array
    {
        return [
            'library_id' => [
                'required',
                'exists:libraries,id',
                new LibraryHasUser()
            ],
            'book_id' => ['required', 'exists:books,id', new BookIsAvailable()],
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function handle(array $data): bool
    {
        $book = Book::whereId($data['book_id'])->first();

        $book->status = BookStatus::OUT_WITH_A_MEMBER;
        $book->user_id = $data['user_id'];

        return $book->save();
    }

    public function asController(ActionRequest $request): RedirectResponse
    {
        /** @var Associate|null $associate */
        $borrowed = $this->handle($request->validated());

        $session = $request->session();

        if (!$borrowed) {
            $session->flash('flash.banner', 'Something went wrong');
            $session->flash('flash.bannerStyle', 'error');

            return redirect()->back();
        }

        $session->flash('flash.banner', 'The book is borrowed by user.');
        $session->flash('flash.bannerStyle', 'success');

        return redirect()->route('dashboard');
    }
}
