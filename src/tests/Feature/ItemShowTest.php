<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function item_detail_shows_all_required_information()
    {
        $this->seed();

        $user = User::factory()->create();

        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 3000,
            'description' => 'テスト用の商品説明です。',
            'condition' => '良好',
            'img_url' => 'test.jpg',
            'user_id' => $user->id,
        ]);

        $category = Category::factory()->create(['name' => '家電']);
        $item->categories()->attach($category->id);

        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $commentUser = User::factory()->create(['name' => 'コメントユーザー']);
        Comment::create([
            'user_id' => $commentUser->id,
            'item_id' => $item->id,
            'content' => '良い商品ですね！',
        ]);

        $response = $this->get(route('items.show', ['item_id' => $item->id]));

        $response->assertStatus(200);

        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('¥3,000');

        $response->assertSee('テスト用の商品説明です。');
        $response->assertSee('良好');

        $response->assertSee('家電');

        $response->assertSee('1');

        $response->assertSee('コメント (1)');

        $response->assertSee('コメントユーザー');
        $response->assertSee('良い商品ですね！');
    }
    /** @test */
    public function item_detail_shows_multiple_categories()
    {
        $this->seed();

        $user = User::factory()->create();

        $item = Item::factory()->create([
            'name' => 'カテゴリテスト商品',
            'brand' => 'カテゴリブランド',
            'price' => 2000,
            'description' => 'カテゴリテスト説明',
            'condition' => '新品',
            'img_url' => 'test.jpg',
            'user_id' => $user->id,
        ]);

        $category1 = \App\Models\Category::factory()->create(['name' => 'アクセサリー']);
        $category2 = \App\Models\Category::factory()->create(['name' => 'ファッション']);

        $item->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get(route('items.show', ['item_id' => $item->id]));

        $response->assertStatus(200);

        $response->assertSee('アクセサリー');
        $response->assertSee('ファッション');
    }
}
