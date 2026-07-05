<?php

namespace Tests\Feature\Profile;

use App\Models\Item;
use App\Models\Order;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MypageTest extends TestCase
{
    use RefreshDatabase;

    public function test_必要な情報が取得できる()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'email_verified_at' => now(),
        ]);

        Profile::factory()->create([
            'user_id' => $user->id,
            'image' => 'profiles/test.png',
        ]);

        Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品',
        ]);

        $purchasedItem = Item::factory()->create([
            'name' => '購入商品',
        ]);

        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $purchasedItem->id,
        ]);

        $sellResponse = $this->actingAs($user)->get('/mypage?page=sell');

        $sellResponse->assertStatus(200);
        $sellResponse->assertSee('テストユーザー');
        $sellResponse->assertSee('profiles/test.png');
        $sellResponse->assertSee('出品商品');

        $buyResponse = $this->actingAs($user)->get('/mypage?page=buy');

        $buyResponse->assertStatus(200);
        $buyResponse->assertSee('購入商品');
    }
}