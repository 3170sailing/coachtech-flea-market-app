<?php

namespace Tests\Feature\Item;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_「商品名」で部分一致検索ができる()
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

        $response = $this->get('/?keyword=時計');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
        $response->assertDontSee('HDD');
    }

    public function test_検索状態がマイリストでも保持されている()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $watch = Item::factory()->create([
            'name' => '腕時計',
        ]);

        $hdd = Item::factory()->create([
            'name' => 'HDD',
        ]);

        $watch->likes()->create([
            'user_id' => $user->id,
        ]);

        $hdd->likes()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/?page=mylist&keyword=時計');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
        $response->assertDontSee('HDD');
    }
}