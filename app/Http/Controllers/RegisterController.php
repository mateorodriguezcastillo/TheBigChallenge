<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Notifications\VerifyEmail;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $role = Role::where('name', $request->validated()['role'])->firstOrFail();
        $user = $role->users()->create($request->validated());
        $token = $user->createToken($request->ip())->plainTextToken;
        $user->notify(new VerifyEmail);
        return responder()
            ->success($user, UserTransformer::class)
            ->meta(['token' => $token])
            ->respond();
    }
}
