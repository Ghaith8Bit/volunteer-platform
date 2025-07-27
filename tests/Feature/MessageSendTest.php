<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MessageSendTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_send_message_to_self(): void
    {
        $user = User::factory()->create(['role' => 'volunteer']);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/volunteer/messages/send', [
            'receiver_id' => $user->id,
            'message_text' => 'hello',
        ]);

        $response->assertStatus(422)
                 ->assertJson(['message' => 'Cannot message yourself']);
    }
}
