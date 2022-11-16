<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GetSubmissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ((auth()->user()->role->id === Role::PATIENT && auth()->user()->id !== $request->submission->patient_id)
                ||
            (auth()->user()->role->id === Role::DOCTOR && $request->submission->doctor_id != NULL && auth()->user()->id !== $request->submission->doctor_id)) {
            return responder()
                ->error()
                ->respond(Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
