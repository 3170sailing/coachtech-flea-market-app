<?php

namespace Tests\Feature\Item;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_ログイン済みユーザーはコメントを送信できる()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'content' => 'テストコメント',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);

        $response->assertRedirect();
    }

    public function test_ログイン前のユーザーはコメントを送信できない()
    {
        $item = Item::factory()->create();

        $response = $this->post("/item/{$item->id}/comment", [
            'content' => 'テストコメント',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
    }

    public function test_コメントが入力されていない場合、バリデーションメッセージが表示される()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'content' => '',
        ]);

        $response->assertSessionHasErrors('content');
    }

    public function test_コメントが255字以上の場合、バリデーションメッセージが表示される()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/item/{$item->id}/comment", [
            'content' => str_repeat('あ', 256),
        ]);

        $response->assertSessionHasErrors('content');
    }
}