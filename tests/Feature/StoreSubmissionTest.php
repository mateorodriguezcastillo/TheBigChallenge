<?php

namespace Tests\Feature;

use App\Models\Role;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreSubmissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider  invalidUserDataProvider
     */
    public function test_user_cant_register_with_invalid_data($submission): void
    {
        $role = Role::create(['name' => 'patient']);
        $user = UserFactory::new()->create(['role_id' => $role->id]);
        $this->actingAs($user);
        $response = $this->postJson(route('submission.store'), $submission);
        $response->assertUnprocessable();
    }

    public function invalidUserDataProvider(): array
    {
        return [
            ['no Title' => [
                'info' => 'info',
                'symptoms' => 'symptoms',
            ]],
            ['no Info' => [
                'title' => 'title',
                'symptoms' => 'symptoms',
            ]],
            ['no Symptoms' => [
                'title' => 'title',
                'info' => 'info',
            ]],
        ];
    }

    public function test_it_requires_authentication(): void
    {
        $this->postJson(route('submission.store'))
            ->assertUnauthorized();
    }

    public function test_patient_can_submit(): void
    {
        $role = Role::create(['name' => 'patient']);
        $user = UserFactory::new()->create(['role_id' => $role->id]);
        $submission = [
            'title' => 'title',
            'info' => 'info',
            'symptoms' => 'symptoms',
        ];
        $response = $this->actingAs($user)->postJson(route('submission.store'), $submission);
        $response->assertSuccessful();
        $this->assertDatabaseHas('submissions', [
            'patient_id' => $user->id,
            'title' => $submission['title'],
            'info' => $submission['info'],
            'symptoms' => $submission['symptoms'],
            'status' => 'pending',
        ]);
    }

    public function test_doctor_cant_submit(): void
    {
        $role = Role::create(['name' => 'doctor']);
        $user = UserFactory::new()->create(['role_id' => $role->id]);
        $submission = [
            'title' => 'title',
            'info' => 'info',
            'symptoms' => 'symptoms',
        ];
        $response = $this->actingAs($user)->postJson(route('submission.store'), $submission);
        $response->assertForbidden();
    }


}
