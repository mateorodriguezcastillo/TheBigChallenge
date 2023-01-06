<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testLoggedOutUnsuccessfully(): void
    {
        $response = $this->postJson(route('user.logout'), $headers = [
            'bearer' => 'faketoken123',
        ]);

        $response->assertUnauthorized();
    }
}
