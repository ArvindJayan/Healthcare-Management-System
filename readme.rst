🏥 Healthcare Management System (HMS)

A web-based **Healthcare Management System (HMS)** built with the **CodeIgniter 3** PHP framework and **Bootstrap 5**. The portal facilitates seamless coordination between **Patients**, **Doctors**, and **Administrators** by managing patient records, doctor specializations, appointment scheduling, and digital prescriptions with Role-Based Access Control (RBAC).

---

 🚀 Key Features

👤 Role-Based Access Control (RBAC)
* **Administrator (Role 1):** Full oversight over system records, doctor directories, patient profiles, and appointment logs.
* **Doctor (Role 2):** Manage patient visits, view personal daily consultation queues, and update diagnoses and digital prescriptions.
* **Patient (Role 3):** Browse specialized doctors, schedule consultation slots, track appointment history, and update personal profile details.

---

📦 Key Modules

* **🔐 Authentication & Security:**
  * Secure user registration and authentication with BCrypt password hashing (`password_hash()`).
  * Role-specific navigation, authentication checks on controller constructors, and session management.

* **🩺 Doctor Management:**
  * Directory listing with search functionality and specialization filtering.
  * Multi-table database transactions keeping user credentials and doctor profiles in sync.

* **📑 Patient Management:**
  * Centralized directory for patient records, contact details, date of birth, gender, and clinical notes.

* **📅 Appointments Module:**
  * Interactive appointment booking workflow with preferred date and time selection.
  * Status transition tracking (*Pending*, *Completed*, *Cancelled*).
  * Clinical outcome tracking including doctor diagnoses and prescription notes.

* **⚙️ Profile Settings:**
  * Dynamic top navigation bar with user avatar, name, role badge, and quick-access dropdown.
  * Profile customization for personal info, role-specific attributes, and password updates.

---

 🛠️ Tech Stack

| Layer | Technology |
| :--- | :--- |
| **Backend Framework** | PHP 7.4+ / CodeIgniter 3 |
| **Database** | MySQL 5.7+ / MariaDB |
| **Frontend Framework** | HTML5, CSS3, JavaScript (ES6 / Fetch API) |
| **UI Components & Icons** | Bootstrap 5.3, Bootstrap Icons 1.11 |

---

📂 Database Schema Overview

The system operates on four main relational tables:

```text
├── users
│   ├── id (INT, PRIMARY KEY, AUTO_INCREMENT)
│   ├── name (VARCHAR)
│   ├── email (VARCHAR, UNIQUE)
│   ├── password (VARCHAR)
│   ├── role_id (INT) [1: Admin, 2: Doctor, 3: Patient]
│   └── created_at (TIMESTAMP)
│
├── doctors
│   ├── id (INT, PRIMARY KEY, AUTO_INCREMENT)
│   ├── user_id (INT, FOREIGN KEY -> users.id)
│   ├── specialization (VARCHAR)
│   ├── consultation_fee (DECIMAL)
│   └── phone (VARCHAR)
│
├── patients
│   ├── id (INT, PRIMARY KEY, AUTO_INCREMENT)
│   ├── user_id (INT, FOREIGN KEY -> users.id)
│   ├── phone (VARCHAR)
│   ├── dob (DATE)
│   ├── gender (ENUM: 'Male', 'Female', 'Other')
│   └── address (TEXT)
│
└── appointments
    ├── id (INT, PRIMARY KEY, AUTO_INCREMENT)
    ├── patient_id (INT, FOREIGN KEY -> patients.id)
    ├── doctor_id (INT, FOREIGN KEY -> doctors.id)
    ├── appointment_date (DATE)
    ├── appointment_time (TIME)
    ├── status (ENUM: 'Pending', 'Completed', 'Cancelled')
    ├── diagnosis (TEXT)
    ├── prescription (TEXT)
    └── created_at (TIMESTAMP)
