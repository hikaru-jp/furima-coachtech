<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseFlowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_purchase_an_item()
    {
        $this->seed();

        $user = User::factory()->create();

        Address::create([
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address_line' => 'テスト市テスト町',
            'building_name' => 'テストビル',
            'item_id' => null,
        ]);

        $this->actingAs($user);

        $item = Item::factory()->create([
            'user_id' => 1,
            'is_sold' => false,
        ]);

        $response = $this->post(route('purchase.store', ['item_id' => $item->id]), [
            'payment_method' => 'credit',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'is_sold' => true,
        ]);
    }

    /** @test */
    public function purchased_item_is_shown_as_sold_on_index_page()
    {
        $this->seed();

        $buyer = User::factory()->create();

        Address::create([
            'user_id' => $buyer->id,
            'postal_code' => '123-4567',
            'address_line' => 'テスト市テスト町',
            'building_name' => 'テストビル',
            'item_id' => null,
        ]);

        $this->actingAs($buyer);

        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'is_sold' => false,
            'name' => '購入テスト商品',
        ]);

        $this->post(route('purchase.store', ['item_id' => $item->id]), [
            'payment_method' => 'credit',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }
    /** @test */
    public function purchased_item_is_listed_in_purchase_history()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user);

        \App\Models\Address::factory()->create([
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address_line' => 'テスト市テスト町',
            'building_name' => 'テストビル',
        ]);

        $item = \App\Models\Item::factory()->create([
            'user_id' => 1,
            'is_sold' => false,
        ]);

        $response = $this->post(route('purchase.store', ['item_id' => $item->id]), [
            'payment_method' => 'credit',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
