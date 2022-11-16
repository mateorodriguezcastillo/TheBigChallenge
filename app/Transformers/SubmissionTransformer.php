<?php

namespace App\Transformers;

use App\Models\Submission;
use Flugg\Responder\Transformers\Transformer;

class SubmissionTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [
        'patient',
        'doctor',
    ];

    /**
     * Transform the model.
     *
     * @param  \App\Submission $submission
     * @return array
     */
    public function transform(Submission $submission)
    {
        return [
            'id' => (int) $submission->id,
            'title' => (string) $submission->title,
            'info' => (string) $submission->info,
            'symptoms' => (string) $submission->symptoms,
            'status' => (string) $submission->status,
            'created_at' => (string) $submission->created_at,
        ];
    }
}
