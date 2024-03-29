<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\User;
use Flugg\Responder\Transformers\Transformer;

class UserTransformer extends Transformer
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
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\User $user
     * @return array
     */

    public function transform(User $user): array
    {
        return [
            'id' => (int) $user->id,
            'name' => (string) $user->name,
            'email' => (string) $user->email,
            'role' => (string) $user->role->name,
            'isComplete' => (bool) $user->isComplete,
            'phone' => (string) $user->phone,
            'weight' => (int) $user->weight,
            'height' => (int) $user->height,
            'other_info' => (string) $user->other_info,
            'isComplete' => (bool) $user->isComplete,
        ];
    }
}
