<?php

namespace Tests\Feature;

use App\Models\Role;
use Database\Factories\RoleFactory;
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
        $response = $this->postJson(route('user.register'), $user);
        $response->assertUnprocessable();
    }

    public function invalidUserDataProvider(): array
    {
        return [
            ['no Name' => [
                'email' => 'mateo@mail.com',
                'password' => 'Mateo123!',
                'password_confirmation' => 'Mateo123!',
                'role' => Role::DOCTOR,
            ]],
            ['no Password' => [
                'name' => 'mateo',
                'email' => 'mateo@mail.com',
                'role' => Role::DOCTOR,
            ]],
            ['no Password Confirmation' => [
                'name' => 'mateo',
                'email' => 'mateo@mail.com',
                'password' => 'Mateo123!',
                'role' => Role::DOCTOR,
            ]],
            ['no email' => [
                'name' => 'mateo',
                'password' => 'Mateo123!',
                'password_confirmation' => 'Mateo123!',
                'role' => Role::DOCTOR,
            ]],
            ['invalid email' => [
                'name' => 'mateo',
                'email' => 'mateo.com',
                'password' => 'Mateo123!',
                'password_confirmation' => 'Mateo123!',
                'role' => Role::DOCTOR,
            ]],
            ['invalid password' => [
                'name' => 'mateo',
                'email' => 'mateo@mail.com',
                'password' => 'mateo',
                'password_confirmation' => 'mateo',
                'role' => Role::DOCTOR,
            ]],
            ['invalid password confirmation' => [
                'name' => 'mateo',
                'email' => '',
                'password' => 'Mateo123!',
                'password_confirmation' => 'Mateo123',
                'role' => Role::DOCTOR,
            ]],
            ['invalid role' => [
                'name' => 'mateo',
                'email' => '',
                'password' => 'Mateo123!',
                'password_confirmation' => 'Mateo123!',
                'role' => 'invalid_role',
            ]],
        ];
    }

    const VALID_USER = [
        'name' => 'mateo',
        'email' => 'mateo@mail.com',
        'password' => 'Mateo123!',
        'password_confirmation' => 'Mateo123!',
        'role' => Role::DOCTOR,
    ];

    public function testRegisterSuccessfully(): void
    {
        RoleFactory::new()->doctor()->create();

        $response = $this->postJson(route('user.register'), self::VALID_USER);

        $response->assertSuccessful();

        $this->assertDatabaseHas('users', ['email' => 'mateo@mail.com']);
    }

    public function testRegisterTakenEmail(): void
    {
        RoleFactory::new()->doctor()->create();

        $this->postJson(route('user.register'), self::VALID_USER);

        $response = $this->postJson(route('user.register'), self::VALID_USER);

        $response->assertUnprocessable();
    }
}
