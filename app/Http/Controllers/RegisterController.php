<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use App\Models\Role;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;

class RegisterController
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $role = Role::find($request->validated()['role_id']);
        $user = $role->users()->create($request->validated());
        $token = $user->createToken($request->ip())->plainTextToken;
        event(new Registered($user));
        return responder()
            ->success($user, UserTransformer::class)
            ->meta(['token' => $token])
            ->respond();
    }
}
