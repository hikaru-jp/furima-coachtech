<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentStoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function logged_in_user_can_post_comment()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create();

        $response = $this->post("/item/{$item->id}/comment", [
            'content' => 'テストコメント',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
    }
    /** @test */
    public function guest_user_cannot_post_comments()
    {
        $this->seed();

        $item = \App\Models\Item::factory()->create([
            'user_id' => 1,
        ]);

        $response = $this->post("/item/{$item->id}/comment", [
            'content' => 'テストコメント',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'content' => 'テストコメント',
        ]);
    }
    /** @test */
    public function comment_validation_error_is_shown_when_content_is_empty()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create([
            'user_id' => 1,
        ]);

        $response = $this->post(route('comments.store', ['item_id' => $item->id]), ['content' => '']);

        $response->assertStatus(302);

        $response->assertSessionHasErrors(['content']);
    }
    /** @test */
    public function comment_over_255_chars_shows_validation_error()
    {
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user);

        $item = Item::factory()->create([
            'user_id' => 1,
        ]);

        $longComment = str_repeat('あ', 256);

        $response = $this->post('/item/' . $item->id . '/comment', [
            'content' => $longComment,
        ]);

        $response->assertStatus(302);

        $response->assertSessionHasErrors(['content']);

        $response = $this->followingRedirects()->post('/item/' . $item->id . '/comment', [
            'content' => $longComment,
        ]);

        $response->assertSee('The content must not be greater than 255 characters.');

    }
}
