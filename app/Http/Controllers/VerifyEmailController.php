<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request, User $user): JsonResponse
    {
        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException();
        }

        if ($user->hasVerifiedEmail()) {
            return responder()->error(Response::HTTP_UNPROCESSABLE_ENTITY, 'Email already verified')->respond(
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        return responder()->success()->meta(['message' => 'Email has been verified'])->respond();
    }
}
