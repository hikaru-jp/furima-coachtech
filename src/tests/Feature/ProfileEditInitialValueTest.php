<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileEditInitialValueTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function profile_edit_page_shows_previous_values_as_initial_values()
    {
        $user = User::factory()->create([
            'name' => '前回のユーザー名',
            'is_profile_completed' => true,
        ]);

        Address::factory()->create([
            'user_id' => $user->id,
            'postal_code' => '111-2222',
            'address_line' => 'テスト市テスト町1-2-3',
            'building_name' => 'テストビル505',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('mypage.profile'));

        $response->assertStatus(200);

        $response->assertSee('前回のユーザー名');
        $response->assertSee('111-2222');
        $response->assertSee('テスト市テスト町1-2-3');
        $response->assertSee('テストビル505');
    }
}
