<?php

namespace Tests\Feature;

use App\Enums\Status;
use Database\Factories\SubmissionFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AcceptSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_cant_accept_submission_if_not_pending()
    {
        $doctor = UserFactory::new()->doctor()->create();
        $submission = SubmissionFactory::new()->create(['doctor_id' => null, 'status' => Status::IN_PROGRESS]);

        $response = $this->actingAs($doctor)->putJson(route('submission.accept', $submission));
        $response->assertStatus(Response::HTTP_CONFLICT);
    }

    public function test_doctor_cant_accept_submission_if_already_assigned()
    {
        $doctor = UserFactory::new()->doctor()->create();
        $submission = SubmissionFactory::new()->create(['status' => Status::PENDING]);

        $response = $this->actingAs($doctor)->putJson(route('submission.accept', $submission));
        $response->assertStatus(Response::HTTP_CONFLICT);
    }

    public function test_patient_cant_accept_submission()
    {
        $patient = UserFactory::new()->patient()->create();
        $submission = SubmissionFactory::new()->create(['doctor_id' => null, 'status' => Status::PENDING]);

        $response = $this->actingAs($patient)->putJson(route('submission.accept', $submission));
        $response->assertForbidden();
    }

    public function test_guest_cant_accept_submission()
    {
        $submission = SubmissionFactory::new()->create(['doctor_id' => null, 'status' => Status::PENDING]);

        $response = $this->putJson(route('submission.accept', $submission));
        $response->assertUnauthorized();
    }

    public function test_submission_successfully_assigned_to_doctor()
    {
        $doctor = UserFactory::new()->doctor()->create();
        $submission = SubmissionFactory::new()->create(['doctor_id' => null, 'status' => Status::PENDING]);

        $response = $this->actingAs($doctor)->putJson(route('submission.accept', $submission));
        $response->assertSuccessful();

        $this->assertDatabaseHas('submissions', [
            'id' => $submission->id,
            'doctor_id' => $doctor->id,
        ]);
    }
}
