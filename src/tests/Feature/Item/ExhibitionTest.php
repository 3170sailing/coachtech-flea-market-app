<?php

namespace Tests\Feature\Item;

use App\Models\Category;
use App\Models\Condition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

    private function createTestImage()
    {
        $image = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/p9sAAAAASUVORK5CYII='
        );

        $path = tempnam(sys_get_temp_dir(), 'test_image');
        file_put_contents($path, $image);

        return new UploadedFile(
            $path,
            'item.png',
            'image/png',
            null,
            true
        );
    }

    public function test_商品出品画面にて必要な情報が保存できる()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $category = Category::factory()->create([
            'name' => 'ファッション',
        ]);

        $condition = Condition::factory()->create([
            'name' => '良好',
        ]);

        $response = $this->actingAs($user)->post('/sell', [
            'image' => $this->createTestImage(),
            'categories' => [$category->id],
            'condition_id' => $condition->id,
            'name' => '出品商品',
            'brand' => 'テストブランド',
            'description' => '出品テスト説明',
            'price' => 5000,
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'name' => '出品商品',
            'brand' => 'テストブランド',
            'description' => '出品テスト説明',
            'price' => 5000,
        ]);

        $this->assertDatabaseHas('category_items', [
            'category_id' => $category->id,
        ]);
    }
}