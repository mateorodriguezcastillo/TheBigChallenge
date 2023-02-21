<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $token = $request->user()->tokens()->where('name', 'token-' . Auth::user()->id)->first();
        $token->delete();
        return responder()->success()->meta(['message' => 'Logged out successfully'])->respond();
    }
}
