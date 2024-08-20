<?php

namespace App\Listeners;

use App\Events\SubmissionSaved;
use Illuminate\Support\Facades\Log;

class LogSubmissionSaved
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SubmissionSaved $event): void
    {
        $submission = $event->submission;
        Log::info("Submission saved: {$submission->name}, {$submission->email}");
    }
}
