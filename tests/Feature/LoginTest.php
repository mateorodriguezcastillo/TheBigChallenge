<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginSuccess(): void
    {
        $userInfo = [
            'name' => 'Mateo',
            'email' => 'mateo@mail.com',
            'password' => 'Mateo123!',
        ];
        User::newFactory()->patient()->create($userInfo);
        $this->postJson('api/login', $userInfo)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'role',
                ],
                'token',
            ]);
    }

    /**
     * @dataProvider invalidInformationLoginUser
     */
    public function testLoginErrorCases($data): void
    {
        $this->postJson('api/login', $data)->assertUnprocessable();
    }

    public function invalidInformationLoginUser()
    {
        return [
            ['no email' => [
                'password' => 'Mateo123!'
            ]],
            ['no password' => [
                'email' => 'mateo@mail.com'
            ]]
        ];
    }

    /**
     * @dataProvider wrongEmailPasswordInformation
     */
    public function testWrongEmailPassword($data): void
    {
        User::newFactory()->create([
            'email' => 'mateo@mail.com',
            'password' => 'Mateo123!',
        ]);

        $this->postJson('api/login', $data)->assertUnauthorized();
    }

    public function wrongEmailPasswordInformation(): array
    {
        return [
            ['wrong password' => [
                'email' => 'mateo@mail.com',
                'password' => 'WrongPassword123'
            ]],
            ['wrong email' => [
                'email' => 'WrongEmail@gmail.com',
                'password' => 'Mateo123!'
            ]]
        ];
    }
}
