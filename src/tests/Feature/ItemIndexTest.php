<?php

namespace Tests\Feature;

use App\Models\Item;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_index_page_is_displayed()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_all_items_are_displayed()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertSee('腕時計');
        $response->assertSee('HDD');
        $response->assertSee('玉ねぎ3袋');
        $response->assertSee('革靴');
        $response->assertSee('ノートPC');
        $response->assertSee('マイク');
        $response->assertSee('ショルダーバッグ');
        $response->assertSee('タンブラー');
        $response->assertSee('コーヒーミル');
        $response->assertSee('メイクセット');
    }
    public function test_sold_label_is_displayed_for_sold_items()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user);

        $soldItem = Item::factory()->create([
            'user_id' => 1,
            'is_sold' => true,
            'name' => 'Soldテスト商品',
        ]);

        $response = $this->get('/');

        $response->assertSee('Sold');
    }
    public function test_my_items_are_not_displayed_in_index()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user);

        $otherUser = User::factory()->create();

        $otherItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'name' => '他人の商品のテスト品',
        ]);

        $myItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の商品のテスト品',
        ]);

        $response = $this->get('/');

        $response->assertSee('他人の商品のテスト品');

        $response->assertDontSee('自分の商品のテスト品');
    }
}
