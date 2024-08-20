<?php

namespace Tests\Unit\Http\Jobs;

use Tests\TestCase;
use App\Jobs\ProcessSubmission;
use App\Models\Submission;
use App\Events\SubmissionSaved;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Exception;

class ProcessSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function testProcessSubmissionSuccess(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'message' => 'This is a test message.',
        ];

        $this->mock(Submission::class, function ($mock) use ($data) {
            $mock->shouldReceive('create')
                ->with($data)
                ->andReturn(new Submission($data));
        });

        Event::fake();

        $job = new ProcessSubmission($data);
        $job->handle();

        Event::assertDispatched(SubmissionSaved::class);

        $this->assertDatabaseHas('submissions', $data);
    }

    public function testProcessSubmissionThrowError(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'message' => 'This is a test message.',
        ];

        Log::shouldReceive('error')->once();

        $this->mock(Submission::class, function ($mock) {
            $mock->shouldReceive('create')
                ->andThrow(new Exception('Database error'));
        });

        $job = new ProcessSubmission($data);
        $job->handle();
    }
}
