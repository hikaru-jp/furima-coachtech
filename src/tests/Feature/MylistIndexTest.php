<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MylistIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_mylist_page_is_displayed()
    {
        $this->seed();
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
    }

    public function test_only_favorited_items_are_displayed()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user);

        $likedItem = Item::factory()->create([
            'name' => 'いいね商品',
            'user_id' => 1,
        ]);

        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $normalItem = Item::factory()->create([
            'name' => '普通の商品',
            'user_id' => 1,
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertSee('いいね商品');

        $response->assertDontSee('普通の商品');
    }

    public function test_sold_label_is_displayed_for_favorited_sold_items()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user);

        $soldItem = Item::factory()->create([
            'name' => 'Sold商品',
            'user_id' => 1,
            'is_sold' => true,
        ]);

        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $soldItem->id,
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertSee('Sold');
    }

    public function test_mylist_shows_nothing_when_user_is_not_logged_in()
    {
        $this->seed();

        $response = $this->get('/?tab=mylist');

        $response->assertDontSee('腕時計');
        $response->assertDontSee('HDD');
        $response->assertDontSee('玉ねぎ3袋');
    }
}
