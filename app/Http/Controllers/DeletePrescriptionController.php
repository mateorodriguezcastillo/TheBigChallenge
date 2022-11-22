<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeletePrescriptionController extends Controller
{
    public function __invoke(Request $request, Submission $submission): JsonResponse
    {
        Storage::disk('do_spaces')->delete($submission->prescription->path);
        $submission->prescription->delete();
        return responder()->success($submission)->respond();
    }
}
