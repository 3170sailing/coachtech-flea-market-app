<?php

namespace Tests\Feature\Profile;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_変更項目が初期値として過去設定されていること()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'email_verified_at' => now(),
        ]);

        Profile::factory()->create([
            'user_id' => $user->id,
            'image' => 'profiles/test.png',
            'postal_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストマンション',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('profiles/test.png');
        $response->assertSee('123-4567');
        $response->assertSee('東京都');
    }
}