<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function items_can_be_searched_by_keyword()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/?keyword=腕');

        $response->assertStatus(200);

        $response->assertSee('腕時計');

        $response->assertDontSee('HDD');
    }
    /** @test */
    public function search_keyword_is_kept_when_switching_to_mylist()
    {
        $this->seed();

        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $item = \App\Models\Item::factory()->create([
            'name' => '腕時計A',
            'user_id' => 1,
        ]);

        \App\Models\Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/?keyword=腕');
        $response->assertSee('腕時計A');

        $response = $this->get('/?tab=mylist&keyword=腕');
        $response->assertSee('腕時計A');
    }
}
