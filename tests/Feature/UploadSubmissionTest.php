<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Models\Submission;
use Database\Factories\SubmissionFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UploadSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_cant_upload_submission_if_not_in_progress()
    {
        $doctor = UserFactory::new()->doctor()->create();
        $submission = SubmissionFactory::new()->create(['doctor_id' => $doctor->id, 'status' => Status::PENDING]);

        $response = $this->actingAs($doctor)->putJson(route('submission.prescription', $submission));
        $response->assertStatus(Response::HTTP_CONFLICT);
    }

    public function test_doctor_cant_upload_submission_if_not_their_own()
    {
        $doctor = UserFactory::new()->doctor()->create();
        $submission = SubmissionFactory::new()->create(['status' => Status::IN_PROGRESS]);

        $response = $this->actingAs($doctor)->putJson(route('submission.prescription', $submission));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_doctor_can_upload_submission()
    {
        $doctor = UserFactory::new()->doctor()->create();
        $submission = SubmissionFactory::new()->create(['doctor_id' => $doctor->id, 'status' => Status::IN_PROGRESS]);

        $response = $this->actingAs($doctor)->putJson(route('submission.prescription', $submission));
        $response->assertSuccessful();
        $this->assertDatabaseHas('submissions', ['id' => $submission->id, 'status' => Status::READY]);
    }

    public function test_patient_cant_upload_submission()
    {
        $patient = UserFactory::new()->patient()->create();
        $submission = SubmissionFactory::new()->create();

        $response = $this->actingAs($patient)->putJson(route('submission.prescription', $submission));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
