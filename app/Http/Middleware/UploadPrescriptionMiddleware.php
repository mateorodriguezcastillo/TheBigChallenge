<?php

namespace App\Http\Middleware;

use App\Enums\Status;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UploadPrescriptionMiddleware
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
        if ($request->user()->role->name !== 'doctor' || $request->user()->id !== $request->submission->doctor_id){
            return responder()
                ->error('You are not authorized to upload a prescription.')
                ->respond(Response::HTTP_FORBIDDEN);
        }
        if ($request->submission->doctor_id === null || $request->submission->status !== Status::IN_PROGRESS) {
            return responder()
                ->error()
                ->respond(Response::HTTP_CONFLICT);
        }
        return $next($request);
    }
}
