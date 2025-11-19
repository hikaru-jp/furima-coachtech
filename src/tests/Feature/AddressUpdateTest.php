<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function updated_address_is_reflected_in_purchase_page()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create([
            'user_id' => 1,
        ]);

        Address::create([
            'user_id' => $user->id,
            'postal_code' => '111-1111',
            'address_line' => '旧住所A',
            'building_name' => '旧ビル101',
            'item_id' => null,
        ]);

        $this->patch(route('address.update', ['item_id' => $item->id]), [
            'item_id' => $item->id,
            'postal_code' => '222-2222',
            'address_line' => '新住所B',
            'building_name' => '新ビル202',
        ]);

        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postal_code' => '222-2222',
            'address_line' => '新住所B',
            'building_name' => '新ビル202',
        ]);

        $response = $this->get(route('purchase.create', ['item_id' => $item->id]));

        $response->assertStatus(200);

        $response->assertSee('222-2222');
        $response->assertSee('新住所B');
        $response->assertSee('新ビル202');
    }
    /** @test */
    public function purchased_item_creates_address_linked_to_item()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user);

        Address::create([
            'user_id' => $user->id,
            'postal_code' => '111-1111',
            'address_line' => '旧住所A',
            'building_name' => '旧ビル101',
            'item_id' => null,
        ]);

        $item = Item::factory()->create([
            'user_id' => 1,
            'is_sold' => false,
        ]);

        $response = $this->post(route('purchase.store', ['item_id' => $item->id]), [
            'payment_method' => 'credit',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postal_code' => '111-1111',
            'address_line' => '旧住所A',
            'building_name' => '旧ビル101',
        ]);
    }
}
