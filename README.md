TO DO LIST API

This is a RESTful API built with Laravel 12 that allows authenticated users to manage a list of todos. It includes user authentication, full CRUD operations for todos, authorization checks.

Authentication is handled using Laravel Sanctum.

Only authenticated users can access the API.

Authenticated users can:

View all their own todos

Create new todos

Update, delete, or view a single todo (only if they own it)

