<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchasePaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function selected_payment_method_is_saved_in_purchase()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user);

        Address::create([
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'address_line' => 'テスト市テスト町',
            'building_name' => 'テストビル',
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

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'credit',
        ]);
    }
}
