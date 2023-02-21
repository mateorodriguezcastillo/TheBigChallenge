<?php

namespace App\Http\Middleware;

use App\Enums\Status;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AcceptSubmissionMiddleware
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
        if ($request->user()->role->name !== Role::DOCTOR) {
            return responder()
                ->error()
                ->respond(Response::HTTP_FORBIDDEN);
        }
        if ($request->submission->doctor_id !== null || $request->submission->status !== Status::PENDING) {
            return responder()
                ->error()
                ->respond(Response::HTTP_CONFLICT);
        }
        return $next($request);
    }
}
