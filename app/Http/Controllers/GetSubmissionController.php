<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Submission;
use App\Transformers\SubmissionTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class GetSubmissionController extends Controller
{
    public function __invoke(Submission $submission): JsonResponse
    {
        // if (auth()->user()->role->id === Role::PATIENT && auth()->user()->id !== $submission->patient_id) {
        //     return responder()
        //         ->error()
        //         ->respond(Response::HTTP_FORBIDDEN);
        // }
        return responder()
            ->success($submission, SubmissionTransformer::class)
            ->respond();
    }
}
