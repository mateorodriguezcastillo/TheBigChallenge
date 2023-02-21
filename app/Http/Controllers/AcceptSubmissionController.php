<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Submission;
use App\Notifications\AcceptedSubmission;
use App\Transformers\SubmissionTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AcceptSubmissionController extends Controller
{
    public function __invoke(Request $request, Submission $submission): JsonResponse
    {
        $submission->doctor_id = $request->user()->id;
        $submission->status = Status::IN_PROGRESS;
        $submission->save();
        $submission->patient->notify(new AcceptedSubmission($submission));
        return responder()
            ->success($submission, SubmissionTransformer::class)
            ->respond();
    }
}
