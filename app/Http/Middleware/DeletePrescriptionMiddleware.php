<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class DeletePrescriptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        if ($request->user()->role->name === Role::DOCTOR && $request->user()->id !== $request->submission->doctor_id) {
            return responder()->error('You are not allowed to delete this prescription.')->respond(HttpResponse::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
