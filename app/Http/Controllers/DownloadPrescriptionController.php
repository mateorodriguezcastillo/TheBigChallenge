<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Support\Facades\Storage;

class DownloadPrescriptionController extends Controller
{
    public function __invoke(Submission $submission)
    {
        $path = Storage::disk('do_spaces')->get($submission->prescription->path);
        $headers = [
            'Content-Type' => 'application/plain',
            'Content-Descrption' => 'File Transfer',
        ];
        return response()->make($path, 200, $headers);
    }
}
