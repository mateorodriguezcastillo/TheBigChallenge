<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmissionRequest;
use App\Transformers\SubmissionTransformer;
use Illuminate\Http\JsonResponse;

class StoreSubmissionController extends Controller
{
    public function __invoke(StoreSubmissionRequest $request): JsonResponse
    {
        $submission = $request->user()->submissions()->create($request->validated());
        return responder()
            ->success($submission, SubmissionTransformer::class)
            ->respond();
    }
}
