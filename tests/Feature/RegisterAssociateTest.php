<?php

namespace Tests\Feature;

use App\Models\Associate;
use App\Models\Library;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterAssociateTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_registered_as_associate(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var Library $library */
        $library = Library::factory()->create();

        $data = [
            'user_id' => $user->id,
            'library_id' => $library->id
        ];

        $this->actingAs($user)->post(route('associates.store'), $data);

        /** @var Associate $associate */
        $associate = Associate::where('user_id', $user->id)
            ->where('library_id', $library->id)
            ->first();

        $this->assertDatabaseHas('associates', $associate->toArray());

        $data = [
            'user_id' => $user->id,
            'library_id' => $library->id
        ];

        $this->actingAs($user)->post(route('associates.store'), $data);

        $count = Associate::where('user_id', $user->id)
            ->where('library_id', $library->id)
            ->count();

        $this->assertEquals(1, $count);
    }
}
