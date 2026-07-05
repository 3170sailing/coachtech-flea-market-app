<?php

namespace Tests\Feature\Item;

use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_いいねアイコンを押下することによって、いいねした商品として登録することができる。()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/item/{$item->id}/like");

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response->assertRedirect();
    }

    public function test_追加済みのアイコンは色が変化する()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create();

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get("/item/{$item->id}");

        $response->assertStatus(200);
        $response->assertSee('ハートロゴ_ピンク.png');
    }

    public function test_再度いいねアイコンを押下することによって、いいねを解除することができる。()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create();

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->post("/item/{$item->id}/like");

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response->assertRedirect();
    }
}