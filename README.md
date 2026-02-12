# CRM System

A web-based **Customer Relationship Management (CRM) System** developed using **Laravel**.  
The system is designed to manage customers, track customer interactions, handle helpdesk tickets, and manage system users with role-based access control.

---

## 📌 Table of Contents

- [Introduction](#introduction)
- [System Requirements](#system-requirements)
- [Installation Guide](#installation-guide)
- [Environment Configuration](#environment-configuration)
- [Database Setup](#database-setup)
- [Project Structure](#project-structure)
- [System Modules](#system-modules)
- [Roles and Permissions](#roles-and-permissions)
- [Third-Party Libraries](#third-party-libraries)
- [Maintenance Commands](#maintenance-commands)

---

## Introduction

The CRM System is developed to support organizations in managing customer information, recording customer interactions, handling helpdesk tickets, and controlling system user access.

The system ensures structured data management, improved service tracking, and efficient internal workflow.

---

## System Requirements

### Software Requirements

- PHP >= 8.2 / 8.3  
- Laravel Framework  
- Composer  
- Node.js & NPM  
- MySQL >= 5.7  
- Apache 

---

## Installation Guide

### 1. Clone Repository

```bash
git clone https://github.com/your-repository/crm-system.git
cd crm-system
```

### 2. Install Dependencies

#### Install PHP Dependencies

```bash
composer install
```

#### Install Frontend Dependencies

```bash
npm install
npm run build
```

---

## Environment Configuration

### 1. Create Environment File

```bash
cp .env.example .env
```

### 2. Configure Database in `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crm
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Generate Application Key

```bash
php artisan key:generate
```

---

## Database Setup

### Run Migration

```bash
php artisan migrate
```

### Run Seeder (if available)

```bash
php artisan db:seed
```

### Create Storage Link

```bash
php artisan storage:link
```

### Start Development Server

```bash
php artisan serve
```

Access the system at:

```
http://127.0.0.1:8000
```

---

## Project Structure

```
app/
    Models/
    Http/Controllers/
resources/
    views/
routes/
database/
public/
```

### Folder Description

- **Models** → Database interaction  
- **Controllers** → Business logic  
- **Views** → Blade templates (UI)  
- **Routes** → Web routes definition  
- **Database** → Migrations and seeders  
- **Public** → Publicly accessible files  

---

## System Modules

### 1. Customer Management

This module manages all customer records within the system.

**Features:**

- Add new customer  
- Edit customer information  
- Delete customer  
- Search and filter customers  
- Form validation  
- View customer details  

---

### 2. Customer Interactions Management

This module records and tracks all interactions between the organization and customers.

**Features:**

- Log customer interactions  
- Categorize interaction types (e.g., call, email, meeting)  
- Attach notes and descriptions  
- View interaction history per customer  
- Filter interaction records  

---

### 3. Helpdesk Ticketing Management

This module handles customer support tickets.

**Features:**

- Create support tickets  
- Assign tickets to support staff  
- Update ticket status (Open, In Progress, Resolved, Closed)  
- Filter tickets by status, priority, or user  
- Export tickets (CSV)  
- Track ticket history  

---

### 4. User Management

This module manages system users and their access levels.

**Features:**

- Create new users  
- Edit user details  
- Delete users  
- Assign roles  
- Manage user status (active/inactive)  

---

## Roles and Permissions

The system implements **Role-Based Access Control (RBAC)** using the  
**spatie/laravel-permission** package.

---

### Spatie Installation & Setup

#### 1. Install Package

```bash
composer require spatie/laravel-permission
```

#### 2. Publish Configuration & Migration

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

#### 3. Run Migration

```bash
php artisan migrate
```

This will create the following tables:

- `roles`
- `permissions`
- `model_has_roles`
- `model_has_permissions`
- `role_has_permissions`

---

### Update User Model

Add the `HasRoles` trait inside `app/Models/User.php`:

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
}
```

---

### Defined System Roles

The system defines the following roles:

- **admin**
- **support**
- **user**

Roles can be created using a seeder or manually:

```php
use Spatie\Permission\Models\Role;

Role::create(['name' => 'admin']);
Role::create(['name' => 'support']);
Role::create(['name' => 'user']);
```

---

### Role Descriptions

#### Admin

- Full system access  
- Manage users and roles  
- Access all modules  
- View reports and exports  
- Configure system settings  

#### Support

- Manage helpdesk tickets  
- Update ticket status  
- View assigned tickets  
- Log customer interactions  
- View customer records  

#### User

- View customer records (if permitted)  
- Create tickets  
- View own tickets  
- View own interactions  

---

### Assign Role to User

```php
$user->assignRole('admin');
$user->assignRole('support');
$user->assignRole('user');
```

---

### Middleware Usage

The following middleware is used:

- `auth`
- `role` middleware provided by Spatie

Example route protection:

```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin-only routes
});

Route::middleware(['auth', 'role:support'])->group(function () {
    // Support-only routes
});
```

---

### Blade Role Checks

```blade
@role('admin')
    <!-- Admin content -->
@endrole

@role('support')
    <!-- Support content -->
@endrole
```

---

This ensures secure and structured access control throughout the CRM system.

## Third-Party Libraries

### 1. Laravel Excel (CSV Export)

Used for exporting ticket and report data.

#### Installation

```bash
composer require maatwebsite/excel
```

#### Publish Configuration

```bash
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
```

#### Example Usage

```php
return Excel::download(new TicketExport($request), 'tickets-report.csv');
```

---

### 2. DomPDF (PDF Generation)

Used for generating PDF reports.

#### Installation

```bash
composer require barryvdh/laravel-dompdf
```

#### Publish Configuration

```bash
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

#### Example Usage

```php
$pdf = PDF::loadView('report.pdf', $data);
return $pdf->download('report.pdf');
```

---

## Maintenance Commands

### Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Log Files Location

```
storage/logs
```

---