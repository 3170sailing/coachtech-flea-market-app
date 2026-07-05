<?php

namespace Tests\Feature\Purchase;

use App\Models\Item;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_小計画面で変更が反映される()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Profile::factory()->create(['user_id' => $user->id]);

        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post('/purchase/' . $item->id, [
            'payment_method' => '',
        ]);

        $response->assertSessionHasErrors('payment_method');
    }
}