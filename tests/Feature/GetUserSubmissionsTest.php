<?php

namespace Tests\Feature;

use Database\Factories\SubmissionFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetUserSubmissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_get_own_submissions(): void
    {
        $user = UserFactory::new()->patient()->create();
        SubmissionFactory::new()->count(10)->create(['patient_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(route('submission.user', $user->id));
        $response->assertSuccessful();
        $response->assertJsonCount(10, 'data');
    }

    public function test_doctor_can_get_own_submissions(): void
    {
        $user = UserFactory::new()->doctor()->create();
        SubmissionFactory::new()->count(10)->create(['doctor_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(route('submission.user', $user->id));
        $response->assertSuccessful();
        $response->assertJsonCount(10, 'data');
    }

    public function test_patient_cannot_get_other_patient_submissions(): void
    {
        $user = UserFactory::new()->patient()->create();
        $otherUser = UserFactory::new()->patient()->create();
        SubmissionFactory::new()->count(10)->create(['patient_id' => $otherUser->id]);

        $response = $this->actingAs($user)->getJson(route('submission.user', $otherUser->id));
        $response->assertForbidden();
    }

    public function test_doctor_cannot_get_other_doctor_submissions(): void
    {
        $user = UserFactory::new()->doctor()->create();
        $otherUser = UserFactory::new()->doctor()->create();
        SubmissionFactory::new()->count(10)->create(['doctor_id' => $otherUser->id]);

        $response = $this->actingAs($user)->getJson(route('submission.user', $otherUser->id));
        $response->assertForbidden();
    }

    public function test_doctor_can_get_submissions_filtered_by_status(): void
    {
        $user = UserFactory::new()->doctor()->create();
        SubmissionFactory::new()->count(10)->create(['doctor_id' => $user->id, 'status' => 'pending']);
        SubmissionFactory::new()->count(10)->create(['doctor_id' => $user->id, 'status' => 'in_progress']);
        SubmissionFactory::new()->count(10)->create(['doctor_id' => $user->id, 'status' => 'ready']);

        $response = $this->actingAs($user)->getJson(route('submission.user', $user->id) . '?status=pending');
        $response->assertSuccessful();
        $response->assertJsonCount(10, 'data');
    }

    public function test_doctor_can_get_submissions_filtered_by_status_and_paginated(): void
    {
        $user = UserFactory::new()->doctor()->create();
        SubmissionFactory::new()->count(20)->create(['doctor_id' => $user->id, 'status' => 'pending']);
        SubmissionFactory::new()->count(10)->create(['doctor_id' => $user->id, 'status' => 'in_progress']);
        SubmissionFactory::new()->count(10)->create(['doctor_id' => $user->id, 'status' => 'ready']);

        $response = $this->actingAs($user)->getJson(route('submission.user', $user->id) . '?status=pending&page=2');
        $response->assertSuccessful();
        $response->assertJsonCount(5, 'data');
    }

    public function test_patient_can_get_submissions_filtered_by_status(): void
    {
        $user = UserFactory::new()->patient()->create();
        SubmissionFactory::new()->count(10)->create(['patient_id' => $user->id, 'status' => 'pending']);
        SubmissionFactory::new()->count(10)->create(['patient_id' => $user->id, 'status' => 'in_progress']);
        SubmissionFactory::new()->count(10)->create(['patient_id' => $user->id, 'status' => 'ready']);

        $response = $this->actingAs($user)->getJson(route('submission.user', $user->id) . '?status=pending');
        $response->assertSuccessful();
        $response->assertJsonCount(10, 'data');
    }

    public function test_patient_can_get_submissions_filtered_by_status_and_paginated(): void
    {
        $user = UserFactory::new()->patient()->create();
        SubmissionFactory::new()->count(20)->create(['patient_id' => $user->id, 'status' => 'pending']);
        SubmissionFactory::new()->count(10)->create(['patient_id' => $user->id, 'status' => 'in_progress']);
        SubmissionFactory::new()->count(10)->create(['patient_id' => $user->id, 'status' => 'ready']);

        $response = $this->actingAs($user)->getJson(route('submission.user', $user->id) . '?status=pending&page=2');
        $response->assertSuccessful();
        $response->assertJsonCount(5, 'data');
    }

}
