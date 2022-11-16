<?php

namespace Tests\Feature;

use Database\Factories\SubmissionFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_get_own_submission(): void
    {
        $user = UserFactory::new()->patient()->create();
        $submission = SubmissionFactory::new()->create(['patient_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(route('submission.show', $submission->id));
        $response->assertSuccessful();
    }

    public function test_doctor_can_get_own_submission(): void
    {
        $user = UserFactory::new()->doctor()->create();
        $submission = SubmissionFactory::new()->create(['doctor_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(route('submission.show', $submission->id));
        $response->assertSuccessful();
    }

    public function test_doctor_can_get_submission_with_no_doctor_assigned(): void
    {
        $user = UserFactory::new()->doctor()->create();
        $submission = SubmissionFactory::new()->create(['doctor_id' => null]);

        $response = $this->actingAs($user)->getJson(route('submission.show', $submission->id));
        $response->assertSuccessful();
    }

    public function test_doctor_cant_get_submission_if_not_owner(): void
    {
        $user = UserFactory::new()->doctor()->create();
        $user2 = UserFactory::new()->doctor()->create();
        $submission = SubmissionFactory::new()->create(['doctor_id' => $user->id]);

        $response = $this->actingAs($user2)->getJson(route('submission.show', $submission->id));
        $response->assertForbidden();
    }

    public function test_patient_cant_get_submission_if_not_owner(): void
    {
        $user = UserFactory::new()->patient()->create();
        $user2 = UserFactory::new()->patient()->create();
        $submission = SubmissionFactory::new()->create(['patient_id' => $user->id]);

        $response = $this->actingAs($user2)->getJson(route('submission.show', $submission->id));
        $response->assertForbidden();
    }

    public function test_user_cant_get_submission_if_not_logged_in(): void
    {
        $submission = SubmissionFactory::new()->create();

        $response = $this->getJson(route('submission.show', $submission->id));
        $response->assertUnauthorized();
    }

}
