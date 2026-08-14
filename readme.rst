````markdown
# Healthcare Management System

A web-based Healthcare Management System built using PHP and CodeIgniter 3. The application provides role-based functionality for administrators, doctors, and patients, including authentication, role-specific onboarding, doctor/patient management, and appointment scheduling.

> **Project Status:** Learning / Development Project

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [User Roles](#user-roles)
- [Technology Stack](#technology-stack)
- [Architecture](#architecture)
- [Project Structure](#project-structure)
- [Authentication Flow](#authentication-flow)
- [Registration and Onboarding Flow](#registration-and-onboarding-flow)
- [Appointment Flow](#appointment-flow)
- [Database Design](#database-design)
- [Request Lifecycle](#request-lifecycle)
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [Security](#security)
- [Known Limitations](#known-limitations)
- [Future Improvements](#future-improvements)
- [Learning Objectives](#learning-objectives)
- [License](#license)

---

## Overview

The Healthcare Management System is a role-based web application designed to manage basic healthcare workflows between patients, doctors, and administrators.

The application is built using the **Model-View-Controller (MVC)** architecture provided by CodeIgniter 3.

The major application areas are:

- User authentication
- User registration
- Role-specific onboarding
- Doctor management
- Patient management
- Appointment scheduling
- Dashboard functionality
- Profile management

At a high level, the application follows this structure:

```text
                    Healthcare Management System
                               |
             +-----------------+-----------------+
             |                 |                 |
       Authentication      Doctor Module    Patient Module
             |                 |                 |
             +-----------------+-----------------+
                               |
                        Appointment Module
````

---

## Features

### Authentication

* User registration
* User login
* User logout
* Session-based authentication
* Password hashing
* Role-based access

### User Management

* Common user information stored separately from role-specific information
* Role assignment during registration
* Role-specific onboarding
* User profile management

### Doctor Management

* Doctor profiles
* Doctor specialization
* Consultation fee
* Doctor listing

### Patient Management

* Patient profiles
* Date of birth
* Gender
* Phone number
* Patient listing

### Appointment Management

* Doctor selection
* Appointment date selection
* Appointment time selection
* Appointment creation
* Appointment status management
* Diagnosis information
* Prescription information

---

## User Roles

The application currently supports three roles:

| Role ID | Role          |
| ------: | ------------- |
|       1 | Administrator |
|       2 | Doctor        |
|       3 | Patient       |

### Administrator

Administrators have elevated access to administrative functionality.

Public registration does not allow users to register themselves as administrators.

### Doctor

Doctors have access to doctor-specific functionality and profile information such as:

* Specialization
* Consultation fee
* Phone number

### Patient

Patients have access to patient-specific functionality such as:

* Viewing doctors
* Booking appointments
* Managing appointments
* Managing their profile

---

## Technology Stack

| Category              | Technology              |
| --------------------- | ----------------------- |
| Backend               | PHP                     |
| Framework             | CodeIgniter 3           |
| Database              | MySQL / MariaDB         |
| Frontend              | HTML5, CSS3, JavaScript |
| UI Framework          | Bootstrap 5             |
| Icons                 | Bootstrap Icons         |
| Database Driver       | MySQLi                  |
| Dependency Management | Composer                |
| Web Server            | Apache                  |

---

## Architecture

The application follows CodeIgniter 3's MVC architecture.

```text
                        HTTP Request
                             |
                             v
                         index.php
                             |
                             v
                     CodeIgniter Bootstrap
                             |
                             v
                           Router
                             |
                             v
                        Controller
                       /           \
                      /             \
                     v               v
                  Model             View
                    |
                    v
                 Database
                    |
                    v
               MySQL / MariaDB
```

### Controller

Controllers are responsible for handling application requests and coordinating the appropriate models and views.

Current controllers include:

* `Auth.php`
* `Appointments.php`
* `Dashboard.php`
* `Doctors.php`
* `Patients.php`
* `Onboarding.php`
* `Profile.php`
* `Home.php`

### Model

Models handle database-related operations.

Current models include:

* `User_model.php`
* `Doctor_model.php`
* `Patient_model.php`
* `Appointment_model.php`

### View

Views contain the application's presentation layer.

The views are organized according to application modules such as:

* Authentication
* Dashboard
* Doctors
* Patients
* Appointments
* Onboarding
* Profile

---

## Project Structure

```text
Healthcare-Management-System/
│
├── application/
│   │
│   ├── config/
│   │
│   ├── controllers/
│   │   ├── Appointments.php
│   │   ├── Auth.php
│   │   ├── Dashboard.php
│   │   ├── Doctors.php
│   │   ├── Home.php
│   │   ├── Onboarding.php
│   │   ├── Patients.php
│   │   └── Profile.php
│   │
│   ├── models/
│   │   ├── Appointment_model.php
│   │   ├── Doctor_model.php
│   │   ├── Patient_model.php
│   │   └── User_model.php
│   │
│   ├── views/
│   │   ├── appointments/
│   │   ├── auth/
│   │   ├── dashboard/
│   │   ├── doctors/
│   │   ├── errors/
│   │   ├── onboarding/
│   │   ├── patients/
│   │   ├── profile/
│   │   └── landing_page.php
│   │
│   └── ...
│
├── assets/
│   └── landing-page/
│
├── system/
│   └── CodeIgniter/
│
├── .htaccess
├── composer.json
├── index.php
├── license.txt
└── readme.rst
```

---

# Authentication Flow

The authentication process is handled primarily by the `Auth` controller and `User_model`.

```text
User
 |
 v
Login / Registration
 |
 v
Auth Controller
 |
 +--> Validate Input
 |
 +--> User Model
 |
 +--> Database
 |
 v
Create Session
 |
 v
Authenticated User
 |
 v
Role-based Application
```

For login, the system verifies the user's credentials and establishes a session containing information about the authenticated user.

The session is subsequently used by other controllers to identify the current user.

---

# Registration and Onboarding Flow

Registration and onboarding are treated as two separate stages.

## Step 1: Registration

The user provides common account information:

* Name
* Email
* Role
* Password
* Password confirmation

The registration request is validated before a user record is created.

---

## Step 2: Create User

After successful validation, the common account information is stored in the `users` table.

Conceptually:

```text
users
---------------------------
id
name
email
password
role_id
created_at
```

The password is hashed before being stored.

---

## Step 3: Create Session

After the user account is created, the application retrieves the newly created user and creates an authenticated session.

The session contains information such as:

* User ID
* Name
* Email
* Role ID
* Role name
* Authentication state

The user is then redirected to the onboarding page.

---

## Step 4: Role-specific Onboarding

The onboarding controller checks the user's role and determines which additional information needs to be collected.

### Doctor Onboarding

Doctors provide information such as:

* Specialization
* Consultation fee

This information is stored in the `doctors` table.

### Patient Onboarding

Patients provide information such as:

* Phone number
* Gender
* Date of birth

This information is stored in the `patients` table.

---

## Registration and Onboarding Architecture

```text
                     Registration
                          |
                          v
                     users table
                          |
                    user_id + role_id
                          |
                          v
                      Onboarding
                     /          \
                    /            \
                   v              v
                Doctor          Patient
                   |              |
                   v              v
              doctors table   patients table
                   |              |
                   +------+-------+
                          |
                          v
                      Dashboard
```

The separation between `users`, `doctors`, and `patients` allows common authentication information to remain separate from role-specific profile information.

---

# Appointment Flow

The basic appointment workflow is:

```text
Patient
   |
   v
Browse Doctors
   |
   v
Select Doctor
   |
   v
Select Date
   |
   v
Select Time
   |
   v
Submit Appointment
   |
   v
Appointments Controller
   |
   v
Appointment Model
   |
   v
appointments table
   |
   v
Appointment Created
```

An appointment associates a patient with a doctor and contains information such as:

* Patient
* Doctor
* Appointment date
* Appointment time
* Status
* Diagnosis
* Prescription

---

# Database Design

The application uses a relational database with separate tables for authentication, role-specific profiles, and appointments.

## Main Tables

```text
users
  |
  +---- doctors
  |
  +---- patients
           |
           +---- appointments
                    |
                    +---- doctors
```

### `users`

Stores common account information.

| Column       | Purpose               |
| ------------ | --------------------- |
| `id`         | User identifier       |
| `name`       | User name             |
| `email`      | Login email           |
| `password`   | Hashed password       |
| `role_id`    | User role             |
| `created_at` | Account creation time |

### `doctors`

Stores doctor-specific information.

| Column             | Purpose                   |
| ------------------ | ------------------------- |
| `id`               | Doctor profile identifier |
| `user_id`          | Associated user           |
| `specialization`   | Medical specialization    |
| `consultation_fee` | Consultation fee          |
| `phone`            | Contact number            |

### `patients`

Stores patient-specific information.

| Column    | Purpose                    |
| --------- | -------------------------- |
| `id`      | Patient profile identifier |
| `user_id` | Associated user            |
| `phone`   | Contact number             |
| `dob`     | Date of birth              |
| `gender`  | Gender                     |
| `address` | Address                    |

### `appointments`

Stores appointment and consultation information.

| Column             | Purpose                  |
| ------------------ | ------------------------ |
| `id`               | Appointment identifier   |
| `patient_id`       | Associated patient       |
| `doctor_id`        | Associated doctor        |
| `appointment_date` | Appointment date         |
| `appointment_time` | Appointment time         |
| `status`           | Appointment status       |
| `diagnosis`        | Diagnosis information    |
| `prescription`     | Prescription information |
| `created_at`       | Creation timestamp       |

---

# Database Relationships

The main relationships can be represented as:

```text
                    users
                   /     \
                  /       \
                 v         v
             doctors     patients
                            |
                            |
                            v
                       appointments
                            ^
                            |
                         doctors
```

More formally:

```text
users
  |
  +-- 1 : 0..1 --> doctors
  |
  +-- 1 : 0..1 --> patients

patients
  |
  +-- 1 : N --> appointments

doctors
  |
  +-- 1 : N --> appointments
```

A user therefore represents the common identity/authentication layer, while `doctors` and `patients` contain role-specific information.

---

# Request Lifecycle

A typical request through the application follows this general flow:

```text
Browser
   |
   | HTTP Request
   v
.htaccess
   |
   v
index.php
   |
   v
CodeIgniter Bootstrap
   |
   v
Router
   |
   v
Controller
   |
   +---------> Model
   |              |
   |              v
   |           Database
   |
   v
View
   |
   v
HTTP Response
```

For example:

```text
GET /doctors
      |
      v
Doctors Controller
      |
      v
Doctor_model
      |
      v
doctors table
      |
      v
Doctor data
      |
      v
Doctors View
      |
      v
HTML Response
```

---

# Installation

## Prerequisites

The following software is required:

* PHP
* Apache
* MySQL or MariaDB
* Composer
* Web browser

---

## 1. Clone the Repository

```bash
git clone https://github.com/ArvindJayan/Healthcare-Management-System.git
```

Then:

```bash
cd Healthcare-Management-System
```

---

## 2. Install Dependencies

Install the Composer dependencies:

```bash
composer install
```

---

## 3. Create the Database

Create a MySQL/MariaDB database for the application.

For example:

```sql
CREATE DATABASE healthcare_management_system;
```

---

## 4. Configure the Database

Open:

```text
application/config/database.php
```

and configure the database connection.

Example:

```php
$db['default'] = array(
    'dsn'      => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'healthcare_management_system',
    'dbdriver' => 'mysqli'
);
```

Replace the values with the credentials for your local environment.

---

# Configuration

## Base URL

Update:

```text
application/config/config.php
```

Set the application's base URL according to your local environment.

For example:

```php
$config['base_url'] = 'http://localhost/hms/';
```

Make sure this is consistent with the project's `.htaccess` configuration.

---

# Running the Application

Place the project inside your Apache web root.

For example:

```text
htdocs/
└── hms/
    └── Healthcare-Management-System/
```

Start:

* Apache
* MySQL

Then open the configured application URL in your browser.

Example:

```text
http://localhost/hms/
```

The exact URL depends on your local Apache configuration.

---

# Security

The application implements several basic security mechanisms.

## Password Hashing

Passwords are hashed using PHP's password hashing functionality before being stored in the database.

## Session-based Authentication

Authenticated users are identified through CodeIgniter sessions.

## Input Validation

User input is validated using CodeIgniter's form validation functionality.

## Role-based Access

Application functionality is separated based on the user's role.

---

# Known Limitations

This project is intended primarily as a learning/development project and should not be considered production-ready healthcare software.

## Appointment Concurrency

Checking whether an appointment slot is available before inserting an appointment does not completely eliminate race conditions.

For example:

```text
Request A                 Request B
    |                         |
    v                         v
Check slot                Check slot
    |                         |
 Available                 Available
    |                         |
    v                         v
 Insert                    Insert
```

Both requests can potentially observe the slot as available.

A production implementation should enforce the relevant business invariant at the database level and handle conflicting concurrent requests appropriately.

---

## Resource-level Authorization

Checking a user's role is not sufficient to determine whether the user owns a particular resource.

For example, if a patient requests:

```text
/appointments/123
```

the application should verify both:

1. The user is authorized to access appointments.
2. Appointment `123` actually belongs to that patient.

This prevents unauthorized access to another user's data.

---

## Transaction Handling

Operations involving multiple related database changes should be evaluated for transactional consistency.

For example:

```text
Create User
    |
    +---- Create Doctor/Patient Profile
```

If one operation succeeds while another fails, the application could potentially be left in an incomplete state.

Database transactions should be considered where atomicity is required.

---

## Production Security

Before production deployment, the following areas should be reviewed and strengthened:

* CSRF protection
* Session security
* Resource-level authorization
* Input validation
* Output encoding
* Rate limiting
* Error handling
* Database constraints
* Audit logging
* Secure configuration
* HTTPS
* Backup and recovery

---

# Future Improvements

Potential future improvements include:

* Database-enforced appointment slot uniqueness
* Better appointment slot management
* Transactional user onboarding
* More granular authorization
* Centralized permission management
* Automated testing
* Improved error handling
* Audit logging
* Database migrations and seeders
* Environment-based configuration
* API documentation
* Improved deployment configuration
* Better separation of business logic from controllers

---

# Learning Objectives

This project was developed as a practical exercise in PHP and CodeIgniter 3.

The main learning objectives include:

* PHP fundamentals
* Object-oriented PHP
* CodeIgniter 3
* MVC architecture
* Routing
* Controllers
* Models
* Views
* MySQL
* Relational database design
* CRUD operations
* Authentication
* Authorization
* Sessions
* Form validation
* Database relationships
* Appointment scheduling
* Backend security
* HTTP request/response lifecycle

A major objective is understanding how a feature moves through the complete application:

```text
HTTP Request
      |
      v
Route
      |
      v
Controller
      |
      v
Validation
      |
      v
Business Logic
      |
      v
Model
      |
      v
Database
      |
      v
Model
      |
      v
Controller
      |
      v
View / Response
```

---

# License

This project is licensed under the MIT License.

See [`license.txt`](license.txt) for more information.

```

That's especially important because a README is supposed to document **what the project currently is**, not what you intend it to become. The sections under **Known Limitations** and **Future Improvements** can then explicitly document the gaps you're aware of.
```
