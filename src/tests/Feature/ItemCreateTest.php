<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function item_can_be_created_with_required_fields()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        $response = $this->post(route('items.store'), [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'これは説明文です。',
            'price' => 3000,
            'condition' => '良好',
            'categories' => [$category1->id, $category2->id],
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('items', [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'これは説明文です。',
            'price' => 3000,
            'condition' => '良好',
            'user_id' => $user->id,
        ]);

        $item = Item::latest()->first();

        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category1->id,
        ]);

        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category2->id,
        ]);
    }
}
