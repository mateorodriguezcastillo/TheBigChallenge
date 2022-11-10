<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider  invalidUserDataProvider
     */
    public function test_user_cant_register_with_invalid_data($user): void
    {
        $response = $this->postJson('/api/register', $user);
        $response->assertUnprocessable();
    }

    public function invalidUserDataProvider(): array
    {
        return [
            ['no Name' => [
                'email' => 'mateo@mail.com',
                'password' => 'Mateo123!',
                'password_confirmation' => 'Mateo123!',
                'role' => 'patient',
            ]],
            ['no Password' => [
                'name' => 'mateo',
                'email' => 'mateo@mail.com',
                'role' => 'patient',
            ]],
            ['no Password Confirmation' => [
                'name' => 'mateo',
                'email' => 'mateo@mail.com',
                'password' => 'Mateo123!',
                'role' => 'patient',
            ]],
            ['no email' => [
                'name' => 'mateo',
                'password' => 'Mateo123!',
                'password_confirmation' => 'Mateo123!',
                'role' => 'patient',
            ]],
            ['invalid email' => [
                'name' => 'mateo',
                'email' => 'mateo.com',
                'password' => 'Mateo123!',
                'password_confirmation' => 'Mateo123!',
                'role' => 'patient',
            ]],
            ['invalid password' => [
                'name' => 'mateo',
                'email' => 'mateo@mail.com',
                'password' => 'mateo',
                'password_confirmation' => 'mateo',
                'role' => 'patient',
            ]],
            ['invalid password confirmation' => [
                'name' => 'mateo',
                'email' => '',
                'password' => 'Mateo123!',
                'password_confirmation' => 'Mateo123',
                'role' => 'patient',
            ]],
            ['invalid role' => [
                'name' => 'mateo',
                'email' => '',
                'password' => 'Mateo123!',
                'password_confirmation' => 'Mateo123!',
                'role' => 'patient1',
            ]],
        ];
    }

    const VALID_USER = [
        'name' => 'mateo',
        'email' => 'mateo@mail.com',
        'password' => 'Mateo123!',
        'password_confirmation' => 'Mateo123!',
        'role' => 'patient',
    ];

    public function testRegisterSuccessfully(): void
    {
        $response = $this->postJson(route('user.register'), self::VALID_USER);

        $response->assertSuccessful();

        $this->assertDatabaseHas('users', ['email' => 'mateo@mail.com']);
    }

    public function testRegisterTakenEmail(): void
    {
        $this->postJson(route('user.register'), self::VALID_USER);

        $response = $this->postJson(route('user.register'), self::VALID_USER);

        $response->assertUnprocessable();
    }
}
