<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DownloadPrescriptionMiddleware
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
        if ($request->user()->role->name === Role::DOCTOR && $request->user()->id !== $request->submission->doctor_id
            || $request->user()->role->name === Role::PATIENT && $request->user()->id !== $request->submission->patient_id) {
            return responder()->error('You are not allowed to download this prescription.')->respond(Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
