<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProfileInfoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function profile_page_shows_all_required_user_info()
    {
        $this->seed();

        $user = User::factory()->create([
            'name' => 'テストユーザー',
        ]);
        $this->actingAs($user);

        $item1 = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品A',
        ]);

        $item2 = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品B',
        ]);

        $seller = User::factory()->create();

        $purchasedItem = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入商品C',
            'is_sold' => true,
        ]);

        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $purchasedItem->id,
            'payment_method' => 'card',
        ]);

        $response = $this->get('/mypage?page=sell');

        $response->assertStatus(200);

        $response->assertSee('テストユーザー');

        $response->assertSee('出品商品A');
        $response->assertSee('出品商品B');

        $responseBuy = $this->get('/mypage?page=buy');

        $responseBuy->assertStatus(200);

        $responseBuy->assertSee('購入商品C');
    }
}
