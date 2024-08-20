<?php

namespace Tests\Unit\Http\Listeners;

use Tests\TestCase;
use App\Listeners\LogSubmissionSaved;
use App\Events\SubmissionSaved;
use App\Models\Submission;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogSubmissionSavedTest extends TestCase
{
    use RefreshDatabase;

    public function testLogSubmissionSaved()
    {
        $submission = new Submission([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'message' => 'This is a test message.',
        ]);

        Log::shouldReceive('info')
            ->once()
            ->with("Submission saved: {$submission->name}, {$submission->email}");

        $event = new SubmissionSaved($submission);
        $listener = new LogSubmissionSaved();
        $listener->handle($event);
    }
}
