<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Transformers\SubmissionTransformer;
use Illuminate\Http\JsonResponse;

class GetSubmissionController extends Controller
{
    public function __invoke(Submission $submission): JsonResponse
    {
        return responder()
            ->success($submission, SubmissionTransformer::class)
            ->respond();
    }
}
