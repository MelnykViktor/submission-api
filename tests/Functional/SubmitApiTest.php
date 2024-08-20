<?php

namespace Tests\Functional;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubmitApiTest extends TestCase
{
    use RefreshDatabase;

    private const CREATE_SUBMISSION_URL = '/api/submit';

    public function testPostSubmissionSuccess(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'message' => 'This is a test message.',
        ];

        $response = $this->postJson(self::CREATE_SUBMISSION_URL, $data);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Submission received and being processed.']);
        $this->assertDatabaseHas('submissions', $data);
    }

    /** @dataProvider submissionProvider */
    public function testPostSubmissionValidationFailed(array $data): void
    {
        $response = $this->postJson(self::CREATE_SUBMISSION_URL, $data);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function submissionProvider(): iterable
    {
        yield 'name is missing' => [[
            'email' => 'john.doe@example.com',
            'message' => 'This is a test message.',
        ]];

        yield 'email is missing' => [[
            'name' => 'John Doe',
            'message' => 'This is a test message.',
        ]];

        yield 'message is missing' => [[
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]];

        yield 'email is invalid' => [[
            'name' => 'John Doe',
            'email' => 'john.doe',
            'message' => 'This is a test message.',
        ]];

        yield 'empty content' => [[]];
    }
}
