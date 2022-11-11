<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;

class RegisterController
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $role = Role::find($request->validated()['role_id']);
        $user = $role->users()->create($request->validated());
        $token = $user->createToken('userToken')->plainTextToken;
        return responder()
            ->success($user, UserTransformer::class)
            ->meta(['token' => $token])
            ->respond();
    }
}
