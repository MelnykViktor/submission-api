<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionRequest;
use App\Jobs\ProcessSubmission;
use Illuminate\Http\JsonResponse;


class SubmissionController extends Controller
{
    public function submit(SubmissionRequest $request): JsonResponse
    {
        ProcessSubmission::dispatch($request->validated());

        return response()->json(['message' => 'Submission received and being processed.'], 200);
    }
}
