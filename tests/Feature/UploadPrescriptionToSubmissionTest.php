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

class UploadPrescriptionToSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_cant_upload_prescription_if_not_in_progress(): void
    {
        $doctor = UserFactory::new()->doctor()->create();
        $submission = SubmissionFactory::new()->create(['doctor_id' => $doctor->id, 'status' => Status::PENDING]);

        $response = $this->actingAs($doctor)->postJson(route('submission.prescription', $submission));
        $response->assertStatus(Response::HTTP_CONFLICT);
    }

    public function test_doctor_cant_upload_prescription_if_not_their_own(): void
    {
        $doctor = UserFactory::new()->doctor()->create();
        $submission = SubmissionFactory::new()->create(['status' => Status::IN_PROGRESS]);

        $response = $this->actingAs($doctor)->postJson(route('submission.prescription', $submission));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_patient_cant_upload_prescription(): void
    {
        $patient = UserFactory::new()->patient()->create();
        $submission = SubmissionFactory::new()->create();

        $response = $this->actingAs($patient)->postJson(route('submission.prescription', $submission));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
