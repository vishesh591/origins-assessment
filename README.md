# Task Management API

A RESTful API built with Laravel that allows users to register, log in, and manage their personal tasks.

## Requirements

- PHP 8.3+
- Composer
- MySQL 8+
- PHP `pdo_mysql` extension

## Installation

Clone the repository and install dependencies:

```bash
git clone <repository-url>
cd origins-ai-assignment

composer install
cp .env.example .env
```

Create a MySQL database named `task_management` and configure your database credentials in `.env`.

Generate the application key and run migrations:

```bash
php artisan key:generate
php artisan migrate
```

Start the development server:

```bash
php artisan serve
```

The API will be available at `http://127.0.0.1:8000/api`.

## API Endpoints

All endpoints accept and return JSON.

| Method | Endpoint | Description | Authentication |
|---|---|---|---|
| POST | `/api/register` | Register a new user | No |
| POST | `/api/login` | Authenticate a user | No |
| POST | `/api/tasks` | Create a task | Required |
| GET | `/api/tasks` | List authenticated user's tasks | Required |

## Authentication

Register or log in to receive an authentication token.

### Register

**POST** `/api/register`

Request:

```json
{
    "name": "Alex Example",
    "email": "alex@example.com",
    "password": "password123"
}
```

### Login

**POST** `/api/login`

Request:

```json
{
    "email": "alex@example.com",
    "password": "password123"
}
```

Both endpoints return an authentication token.

I kept token handling simple here by storing the hashed token on the user. In a bigger app, Sanctum can handle this so I don’t need to write `userFromToken` myself.

Include the token in the Authorization header when accessing protected endpoints:

```text
Authorization: Bearer YOUR_TOKEN
```

## Task Management

### Create Task

**POST** `/api/tasks`

Request:

```json
{
    "title": "Finish assignment",
    "description": "Complete the API work",
    "due_date": "2026-11-15",
    "status": "pending"
}
```

**Fields:**

- `title` – Required.
- `description` – Optional.
- `due_date` – Optional.
- `status` – Optional. Accepted values: `pending`, `in_progress`, `completed`. Defaults to `pending`.

### List Tasks

**GET** `/api/tasks`

Returns all tasks belonging to the authenticated user.

## Key Implementation Details

- Token-based authentication.
- Protected task endpoints.
- Request validation.
- Repository pattern for separating business and data access logic.
- User-specific task retrieval to ensure users can only access their own tasks.
- Database migrations for application tables.
