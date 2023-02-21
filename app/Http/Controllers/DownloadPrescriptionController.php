<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class DownloadPrescriptionController extends Controller
{
    public function __invoke(Submission $submission): JsonResponse
    {
        $path = Storage::get($submission->prescription->path);
        $headers = [
            'Content-Type' => 'application/plain',
            'Content-Descrption' => 'File Transfer',
        ];
        return response()->json($path, 200, $headers);
    }
}
