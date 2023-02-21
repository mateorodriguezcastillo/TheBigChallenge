<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompleteProfileRequest;
use App\Transformers\UserTransformer;

class CompleteProfileController extends Controller
{
    public function __invoke(CompleteProfileRequest $request)
    {
        $user = $request->user();
        $user->phone = $request->validated()['phone'];
        $user->weight = $request->validated()['weight'];
        $user->height = $request->validated()['height'];
        $user->other_info = $request->validated()['other_info'];
        $user->isComplete = true;
        $user->save();
        return responder()
            ->success($user, UserTransformer::class)
            ->respond();
    }
}
