<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Submission;
use App\Notifications\PrescriptionUploaded;
use App\Transformers\SubmissionTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadPrescriptionController extends Controller
{
    public function __invoke(Request $request, Submission $submission): JsonResponse
    {
        $extension = $request->file('prescription')->extension();
        $mimeType = $request->file('prescription')->getMimeType();
        $path = Storage::putFileAs(
            config('filesystems.disks.do_spaces.folder'),
            $request->file('prescription'),
            $submission->id . '.' . $extension
        );
        $submission->prescription()->create([
            'name' => $submission->id . '.' . $extension,
            'path' => $path,
            'mime_type' => $mimeType,
            'size' => $request->file('prescription')->getSize()
        ]);
        $submission->status = Status::READY;
        $submission->save();
        $submission->patient->notify(new PrescriptionUploaded($submission));
        return responder()
            ->success($submission, SubmissionTransformer::class)
            ->respond();
    }
}
