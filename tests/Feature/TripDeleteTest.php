<?php

namespace Tests\Feature;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TripDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_their_own_trip()
    {
        $user = User::factory()->create();
        $trip = Trip::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->delete(route('trips.destroy', $trip));

        $response->assertRedirect(route('trips.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('trips', ['id' => $trip->id]);
    }

    public function test_user_cannot_delete_other_users_trip()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $trip = Trip::factory()->create(['user_id' => $user1->id]);

        $response = $this->actingAs($user2)
            ->delete(route('trips.destroy', $trip));

        $response->assertStatus(403);
        $this->assertDatabaseHas('trips', ['id' => $trip->id]);
    }

    public function test_guest_cannot_delete_trip()
    {
        $trip = Trip::factory()->create();

        $response = $this->delete(route('trips.destroy', $trip));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('trips', ['id' => $trip->id]);
    }
}
