<?php

namespace Tests\Feature\Purchase;

use App\Models\Item;
use App\Models\Order;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_送付先住所変更画面にて登録した住所が商品購入画面に反映されている()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Profile::factory()->create(['user_id' => $user->id]);

        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/purchase/address/' . $item->id, [
            'postal_code' => '987-6543',
            'address' => '大阪府',
            'building' => 'テストビル',
        ]);

        $response->assertRedirect('/purchase/' . $item->id);

        $purchaseResponse = $this->actingAs($user)->get('/purchase/' . $item->id);

        $purchaseResponse->assertSee('987-6543');
        $purchaseResponse->assertSee('大阪府');
        $purchaseResponse->assertSee('テストビル');
    }

    public function test_購入した商品に送付先住所が紐づいて登録される()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $item = Item::factory()->create();

        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postal_code' => '987-6543',
            'address' => '大阪府',
            'building' => 'テストビル',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postal_code' => '987-6543',
            'address' => '大阪府',
            'building' => 'テストビル',
        ]);
    }
}