<?php

namespace Tests\Feature;

use App\Models\Field;
use App\Models\SportType;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FieldTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_can_see_fields_list(): void
    {
        Field::factory()->count(3)->create();

        $response = $this->get(route('fields.index'));

        $response->assertStatus(200);
    }

    public function test_public_can_see_field_detail(): void
    {
        $field = Field::factory()->create();

        $response = $this->get(route('fields.show', $field));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_field(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $venue = Venue::factory()->create();
        $sport = SportType::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.fields.store'), [
            'venue_id'       => $venue->id,
            'sport_type_id'  => $sport->id,
            'name'           => 'Cancha Test',
            'price_per_hour' => 50000,
            'surface'        => 'synthetic',
            'active'         => true,
        ]);

        $response->assertRedirect(route('admin.fields.index'));
        $this->assertDatabaseHas('fields', ['name' => 'Cancha Test']);
    }

    public function test_customer_cannot_access_admin_fields(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->get(route('admin.fields.index'));

        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_fields(): void
    {
        $response = $this->get(route('admin.fields.index'));

        $response->assertRedirect(route('login'));
    }
}