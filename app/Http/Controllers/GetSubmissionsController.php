<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Transformers\SubmissionTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetSubmissionsController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $submissions = Submission::filter($request->all())
            ->paginate(15)
            ->withQueryString();

        return responder()
            ->success($submissions, SubmissionTransformer::class)
            ->respond();
    }
}
