<?php

namespace Tests\Feature\Purchase;

use App\Models\Item;
use App\Models\Order;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_購入するボタンを押すと購入が完了する()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Profile::factory()->create(['user_id' => $user->id]);

        $item = Item::factory()->create(['name' => '購入商品']);

        $response = $this->actingAs($user)
            ->withSession([
                'order_data_' . $item->id => [
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                    'postal_code' => '123-4567',
                    'address' => '東京都',
                    'building' => 'テストマンション',
                    'payment_method' => 'card',
                ],
            ])
            ->get('/purchase/success/' . $item->id);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_購入した商品は商品一覧画面にてsoldと表示される()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $item = Item::factory()->create(['name' => '購入済み商品']);

        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get('/');

        $response->assertSee('購入済み商品');
        $response->assertSee('sold');
    }

    public function test_「プロフィール／購入した商品一覧」に追加されている()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Profile::factory()->create(['user_id' => $user->id]);

        $item = Item::factory()->create(['name' => '購入済み商品']);

        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee('購入済み商品');
    }
}