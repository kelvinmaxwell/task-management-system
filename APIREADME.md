initial steps with related commands
1: pull project from git :git clone git@github.com:kelvinmaxwell/task-management-system.git

2: navigate to directory :cd task-management-system

3: set up env: cp .env.example .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=your_username
DB_PASSWORD=your_password


4: create database and run migration: php artisan migrate

5: run project: php -S localhost:8000 -t public

Api description

POST /api/tasks - End point to create a new task
GET /api/tasks -get all tasks inclusive of filtering and pagination options
example for pagination: GET /api/tasks?page=1&per_page=10
example for filtering by status: GET /api/tasks?status=pending
example for filtering by due date: GET /api/tasks?due_date=2024-12-31
example for filtering by title: GET /api/tasks?search=task1

GET /api/tasks/{id} - Get one task by id
PUT /api/tasks/{id} -Update a give task
DELETE /api/tasks/{id} - Delete task
