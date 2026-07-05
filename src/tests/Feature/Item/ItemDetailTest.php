<?php

namespace Tests\Feature\Item;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_必要な情報が商品詳細ページに表示される()
    {
        $user = User::factory()->create();

        $condition = Condition::factory()->create([
            'name' => '良好',
        ]);

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'name' => '腕時計',
            'brand' => 'Coach',
            'description' => 'テスト商品です',
            'price' => 10000,
            'image' => 'items/test.png',
        ]);

        $category = Category::factory()->create([
            'name' => 'ファッション',
        ]);

        $item->categories()->attach($category->id);

        Like::factory()->count(3)->create([
            'item_id' => $item->id,
        ]);

        Comment::factory()->count(2)->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'content' => 'テストコメント',
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee('腕時計');
        $response->assertSee('Coach');
        $response->assertSee('10,000');
        $response->assertSee('テスト商品です');
        $response->assertSee('良好');
        $response->assertSee('ファッション');
        $response->assertSee('テストコメント');
        $response->assertSee($user->name);

        $response->assertSee('3');
        $response->assertSee('2');

        $response->assertSee('items/test.png');
    }

    public function test_複数選択されたカテゴリが商品詳細ページに表示される()
    {
        $item = Item::factory()->create();

        $category1 = Category::factory()->create([
            'name' => 'ファッション',
        ]);

        $category2 = Category::factory()->create([
            'name' => 'メンズ',
        ]);

        $item->categories()->attach([
            $category1->id,
            $category2->id,
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
    }
}