<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_favorite_an_item()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create([
            'user_id' => 1,
        ]);

        $this->post('/item/' . $item->id . '/favorite');

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
    /** @test */
    public function favorited_item_shows_filled_star_icon()
    {
        $this->seed();

        $user = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => 1,
        ]);

        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('items.show', ['item_id' => $item->id]));

        $response->assertSee('fa-solid fa-star');

        $response->assertDontSee('fa-regular fa-star');
    }
    /** @test */
    public function user_can_unfavorite_an_item()
    {
        $this->seed();

        $user = \App\Models\User::factory()->create();

        $item = \App\Models\Item::factory()->create([
            'user_id' => 1,
        ]);

        \App\Models\Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('favorites.toggle', ['item_id' => $item->id]));

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get(route('items.show', ['item_id' => $item->id]));

        $response->assertDontSee('fa-solid fa-star');

        $response->assertSee('fa-regular fa-star');
    }
}
