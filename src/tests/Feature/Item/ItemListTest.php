<?php

namespace Tests\Feature\Item;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    public function test_全商品を取得できる()
    {
        $user = User::factory()->create();

        Item::factory()->create([
            'user_id' => $user->id,
            'name' => '腕時計',
        ]);

        Item::factory()->create([
            'user_id' => $user->id,
            'name' => 'HDD',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
        $response->assertSee('HDD');
    }

    public function test_購入済み商品はSoldと表示される()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入済み商品',
        ]);

        Order::factory()->create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('購入済み商品');
        $response->assertSee('sold');
    }

    public function test_自分が出品した商品は表示されない()
    {
        $loginUser = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $otherUser = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Item::factory()->create([
            'user_id' => $loginUser->id,
            'name' => '自分の商品',
        ]);

        Item::factory()->create([
            'user_id' => $otherUser->id,
            'name' => '他人の商品',
        ]);

        $response = $this->actingAs($loginUser)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }
}