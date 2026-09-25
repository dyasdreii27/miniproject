# Personal Task Manager

Project Code: WST21-PM-2026-SF

Student Name: _Add your name_

Course & Year: _Add your course and year_

Database Used: SQLite (Laravel's built-in local database option)

## Features

- Add Task
- View Tasks
- Edit Task
- Delete Task
- Update Status (Pending / Completed)

## Setup

Requirements: PHP 8.2+, Composer, and SQLite.

```bash
composer install
php artisan migrate
php artisan serve
```

Open `http://localhost:8000` in a browser. The root URL redirects to the task dashboard.

## Laravel Structure

- `routes/web.php` defines the task routes.
- `app/Http/Controllers/TaskController.php` validates requests and handles CRUD actions.
- `app/Models/Task.php` represents task records.
- `database/migrations` defines the `tasks` table.
- `resources/views/tasks` contains the Blade pages and form partial.