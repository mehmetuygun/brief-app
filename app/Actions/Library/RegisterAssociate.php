<?php

namespace App\Actions\Library;

use App\Models\Associate;
use App\Models\Library;
use App\Models\User;
use App\Rules\LibraryHasNotUser;
use App\Rules\LibraryHasUser;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use phpDocumentor\Reflection\Types\Null_;

class RegisterAssociate
{
    use AsAction;

    public function rules(): array
    {
        return [
            'library_id' => [
                'required',
                'exists:libraries,id',
                new LibraryHasNotUser()
            ],
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function handle(array $data): Associate|null
    {
        return Associate::create($data);
    }

    public function asController(ActionRequest $request): RedirectResponse
    {
        /** @var Associate|null $associate */
        $associate = $this->handle($request->validated());

        $session = $request->session();

        if (!$associate) {
            $session->flash('flash.banner', 'Something went wrong');
            $session->flash('flash.bannerStyle', 'error');

            return redirect()->back();
        }

        $session->flash(
            'flash.banner',
            'User has been register as associate for the library.'
        );
        $session->flash('flash.bannerStyle', 'success');

        return redirect()->route('dashboard');
    }
}
