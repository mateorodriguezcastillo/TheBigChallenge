<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Transformers\SubmissionTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetUserSubmissionsController extends Controller
{
    public function __invoke(Request $request, User $user): JsonResponse
    {
        $submissions = $user->submissions()
            ->filter($request->all())
            ->paginate(8)
            ->withQueryString();

        return responder()
            ->success($submissions, SubmissionTransformer::class)
            ->respond();
    }
}
