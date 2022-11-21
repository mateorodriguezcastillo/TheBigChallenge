<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Submission;
use App\Notifications\PrescriptionUploaded;
use App\Transformers\SubmissionTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadPrescriptionController extends Controller
{
    public function __invoke(Request $request, Submission $submission): JsonResponse
    {
        $submission->doctor_id = $request->user()->id;
        $submission->status = Status::READY;
        $submission->file = $request->file('file');
        $submission->save();
        $submission->patient->notify(new PrescriptionUploaded($submission));
        return responder()
            ->success($submission, SubmissionTransformer::class)
            ->respond();
    }
}
