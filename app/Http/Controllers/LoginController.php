<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class LoginController
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->validated())) {
            return responder()->error('message', 'Incorrect email or password')
                ->respond(Response::HTTP_UNAUTHORIZED);
        }

        if (PersonalAccessToken::findToken($request->bearerToken())) {
            return responder()->error('message', 'You are already logged in')
                ->respond(Response::HTTP_UNAUTHORIZED);
          }

        if (!Auth::user()->email_verified_at) {
            return responder()->error('message', 'Please verify your email account')
                ->respond(Response::HTTP_UNAUTHORIZED);
        }

        $token = Auth::user()->createToken('token-' . Auth::user()->id);
        return responder()
            ->success(Auth::user(), UserTransformer::class)
            ->meta(['token' => $token->plainTextToken])
            ->respond();
    }
}
