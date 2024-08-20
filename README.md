# Submission API

This is a Laravel-based API that accepts user submissions, processes them using a job queue, stores them in a database, and triggers an event upon successful storage. The project includes Docker for containerized development and unit/feature tests for ensuring code quality.

## Features

- **API Endpoint:** Accepts user submissions with `name`, `email`, and `message`.
- **Database:** Stores submissions in a `submissions` table.
- **Job Queue:** Processes submissions asynchronously using Laravel jobs.
- **Events:** Triggers an event after a successful submission, with a listener that logs the event.
- **Docker:** Containerized environment for consistent development and deployment.
- **Unit & Feature Tests:** Ensures the API works as expected.

## Prerequisites

- Docker & Docker Compose
- Git
- Composer (optional, as it's run inside Docker)

## Quick Setup

### 1. Clone the Repository

```bash
git clone git@github.com:MelnykViktor/submission-api.git
cd submission-api
```

### 2. Run the Setup Script

```bash
./setup.sh
```
> Note: Ensure the script has execute permissions. If not, run chmod +x setup.sh to make it executable.

### 3. Access the API
You can test the API using tools like curl or Postman. The API endpoint is:
```
POST /api/submit
```

Example curl Command:
```bash
curl -X POST http://localhost/api/submit \
    -H "Content-Type: application/json" \
    -d '{
        "name": "John Doe",
        "email": "john.doe@example.com",
        "message": "This is a test message."
    }'
```

### 4. Running Tests
```
docker exec -it app php artisan test
```

