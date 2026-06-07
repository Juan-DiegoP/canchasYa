<?php

namespace Tests\Feature;

use App\Models\Field;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_reservation(): void
    {
        $user  = User::factory()->create(['role' => 'customer']);
        $field = Field::factory()->create();

        $response = $this->actingAs($user)->post(route('reservations.store', $field), [
            'date'       => now()->addDay()->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time'   => '12:00',
            'notes'      => null,
        ]);

        $response->assertRedirect(route('reservations.index'));
        $this->assertDatabaseHas('reservations', [
            'user_id'  => $user->id,
            'field_id' => $field->id,
            'status'   => 'pending',
        ]);
    }

    public function test_guest_cannot_create_reservation(): void
    {
        $field = Field::factory()->create();

        $response = $this->post(route('reservations.store', $field), [
            'date'       => now()->addDay()->format('Y-m-d'),
            'start_time' => '10:00',
            'end_time'   => '12:00',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_user_can_cancel_own_pending_reservation(): void
    {
        $user        = User::factory()->create(['role' => 'customer']);
        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'status'  => 'pending',
        ]);

        $response = $this->actingAs($user)->delete(route('reservations.destroy', $reservation));

        $response->assertRedirect(route('reservations.index'));
        $this->assertDatabaseHas('reservations', [
            'id'     => $reservation->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_user_cannot_cancel_another_users_reservation(): void
    {
        $user        = User::factory()->create(['role' => 'customer']);
        $other       = User::factory()->create(['role' => 'customer']);
        $reservation = Reservation::factory()->create([
            'user_id' => $other->id,
            'status'  => 'pending',
        ]);

        $response = $this->actingAs($user)->delete(route('reservations.destroy', $reservation));

        $response->assertStatus(403);
    }

    public function test_admin_can_confirm_reservation(): void
    {
        $admin       = User::factory()->create(['role' => 'admin']);
        $reservation = Reservation::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($admin)->patch(route('admin.reservations.confirm', $reservation));

        $response->assertRedirect();
        $this->assertDatabaseHas('reservations', [
            'id'     => $reservation->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_overlapping_reservation_is_rejected(): void
    {
        $user  = User::factory()->create(['role' => 'customer']);
        $field = Field::factory()->create();
        $date  = now()->addDay()->format('Y-m-d');

        $this->actingAs($user)->post(route('reservations.store', $field), [
            'date'       => $date,
            'start_time' => '10:00',
            'end_time'   => '12:00',
            'notes'      => null,
        ]);

        $response = $this->actingAs($user)->post(route('reservations.store', $field), [
            'date'       => $date,
            'start_time' => '11:00',
            'end_time'   => '13:00',
            'notes'      => null,
        ]);

        $response->assertSessionHasErrors(['overlap']);
    }
}