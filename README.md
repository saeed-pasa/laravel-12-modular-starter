<div style="text-align: center; margin: auto"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></div>

# Laravel 12 - Modular API Starter

This is a production-ready, highly modular, and scalable API starter kit built with Laravel 12. It serves as a robust
foundation for any professional API project, built with best practices and a clean architecture at its core.

This project demonstrates a complete API for a simple "Product Management" system, including authentication, role-based
access control, relationship management (Products & Categories), and asynchronous job processing.

## Core Philosophy

The primary goal of this starter kit is to enforce a clean, maintainable, and testable architecture from day one. It
heavily utilizes domain-driven design (DDD) principles by separating concerns into independent modules and following a
strict layered architecture (C-S-R).

## Key Features

* **Modular Architecture:** Powered by `nwidart/laravel-modules`. Each business domain (User, Product, Category) exists
  in its own isolated module.
* **API Versioning:** All API routes are prefixed with `/api/v1/...` for future-proofing.
* **Authentication:** Stateless JWT-based authentication using `tymon/jwt-auth`.
* **Authorization (RBAC):** Granular role-based access control (`SuperAdmin`, `Content Manager`, `User`) using the
  powerful `spatie/laravel-permission` package.
* **Clean Architecture (C-S-R):** A strict **Controller-Service-Repository** pattern to separate HTTP logic, business
  logic, and data access logic.
* **Data Transfer Objects (DTOs):** Type-safe data transfer between layers using `spatie/laravel-data`.
* **Standardized Responses:** JSON responses are beautifully transformed using **API Resources**.
* **Robust Validation:** All incoming requests are validated using dedicated **Form Requests**.
* **Global Exception Handling:** A centralized exception handler provides standardized JSON error responses (404, 403,
  422, 500, etc.).
* **API Documentation:** Automatic OpenAPI (Swagger) documentation generation via annotations using `l5-swagger`.
* **Queues & Jobs:** Asynchronous job processing for heavy tasks (like sending welcome emails) using the
  Event/Listener/Job pattern.
* **Testing:** Feature tests (PHPUnit) are included to cover authentication and authorization logic.

## Tech Stack

* **Framework:** Laravel 12
* **Modules:** `nwidart/laravel-modules`
* **Authentication:** `tymon/jwt-auth`
* **Authorization:** `spatie/laravel-permission`
* **DTOs:** `spatie/laravel-data`
* **API Docs:** `darkaonline/l5-swagger`
* **Database:** MySQL (Configured)

---

## Installation & Setup

Follow these steps to get the project up and running on your local machine.

### 1. Clone the Repository

```bash
git clone [https://github.com/saeed-pasa/laravel-12-modular-starter.git](https://github.com/saeed-pasa/laravel-12-modular-starter.git)
cd laravel-12-modular-starter
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy the example environment file and generate your application keys.

```bash
# 1. Create your .env file
cp .env.example .env

# 2. Generate Laravel App Key
php artisan key:generate

# 3. Generate JWT Secret Key
php artisan jwt:secret
```

### 4. Configure .env File

Open your .env file and set up your database connection:

```Code snippet
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Also, configure your queue and mail drivers (we use database and log for local development):

```Code snippet
QUEUE_CONNECTION=database
MAIL_MAILER=log
```

### 5. Run Migrations & Seeders

This is the most important step. This single command will create all database tables (including module tables, Spatie
tables, and queue tables) and seed them with all necessary data (roles, permissions, test categories, and test
users).

```bash
php artisan migrate:fresh --seed
```

---

## Running the Application

### 1. Start the Web Server

```bash
php artisan serve
```

Your API will be available at http://127.0.0.1:8000.

### 2. Run the Queue Worker

To process asynchronous jobs (like sending emails), you must run the queue worker in a separate terminal.

```bash
php artisan queue:work
```

### 3. Run the Scheduler (for Cron Jobs)

To enable scheduled tasks (like cleaning carts), the Laravel scheduler needs to be run every minute. In a real server,
you would add a single Cron entry. For local development, you can simulate it by running:

```bash
# This will run any due tasks and then exit
php artisan schedule:run
```

---

## API Documentation (Swagger)

This project is fully documented using OpenAPI annotations.

**1. Generate the Documentation:** Run this command any time you update the `@OA` annotations in the code.

```bash
php artisan l5-swagger:generate
```

**2. View the Documentation:** Visit the following URL in your browser to see the interactive Swagger UI:

http://127.0.0.1:8000/api/documentation

<br>
You can get an auth token from the `POST /api/v1/auth/login` endpoint and use the "Authorize" button to test all secured
endpoints.

---

## Running Tests

The project includes a suite of feature tests to ensure the core API and authorization logic are working correctly. It
uses an in-memory SQLite database (`:memory:`) to run tests quickly and without affecting your local database.

```bash
php artisan test
```

---

## Core Architecture

**Layered Flow (C-S-R + DTO)**

The application follows a strict data flow to ensure separation of concerns:

`HTTP Request` → `FormRequest (Validation & Auth)` → `Controller (HTTP Layer)` → `DTO (Data Transfer)` →
`Service (Business Logic)` → `Repository (Data Access)` → `Model (Database)`

<br>

**Roles & Permissions**

The `RolePermissionSeeder` sets up the following access control:

| Role            | Permissions                                                                   |
|-----------------|-------------------------------------------------------------------------------|
| User            | `view products`, `view categories`                                            |
| Content Manager | All `User` permissions + Full CRUD on `products` + Full CRUD on `categories`  |
| SuperAdmin      | **All Permissions** (including user management, which is not yet implemented) |

### License

This project is open-sourced software licensed under
the [MIT license](https://www.google.com/search?q=https.opensource.org/licenses/MIT).


