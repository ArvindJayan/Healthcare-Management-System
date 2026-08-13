# 🏥 Healthcare Management System (HMS)

A web-based **Healthcare Management System (HMS)** built with the **CodeIgniter 3** PHP framework and **Bootstrap 5**. The portal facilitates seamless coordination between **Patients**, **Doctors**, and **Administrators** by managing patient records, doctor specializations, appointment scheduling, and digital prescriptions with role-based access control (RBAC).

---

## 🚀 Key Features

### 👤 Role-Based Access Control (RBAC)
* **Administrator (Role 1):** Full oversight over system records, doctor directories, patient profiles, and appointment logs.
* **Doctor (Role 2):** Manage patient visits, view personal daily consultation queues, and update diagnosis/prescriptions.
* **Patient (Role 3):** Browse specialized doctors, schedule consultation slots, track appointment history, and update personal health details.

---

### 📦 Key Modules

* **🔐 Authentication & Security:**
  * Secure user registration and login with BCrypt password hashing.
  * Role-specific navigation and session management.

* **🩺 Doctor Management:**
  * Directory listing with search and specialization filter.
  * Multi-table transactions keeping user credentials and doctor profiles synchronized.

* **📑 Patient Management:**
  * Centralized management for patient profiles, contact info, date of birth, and medical notes.

* **📅 Appointments Module:**
  * Interactive booking system with preferred date and time selection.
  * Status workflows (*Pending*, *Completed*, *Cancelled*).
  * Medical outcome tracking (Diagnosis and Prescriptions).

* **⚙️ Profile Settings:**
  * Dynamic, single-row top navigation menu with user avatar dropdown.
  * Profile customization for personal info, role details, and security/password updates.

---

## 🛠️ Tech Stack

* **Backend Framework:** PHP 7.4+ / CodeIgniter 3
* **Database:** MySQL / MariaDB
* **Frontend:** HTML5, CSS3, JavaScript (ES6 / Fetch API)
* **UI Components & Icons:** Bootstrap 5.3, Bootstrap Icons 1.11

---

## 📂 Database Schema Overview

The system operates on four main relational tables:

```text
├── users (id, name, email, password, role_id, created_at)
├── doctors (id, user_id, specialization, consultation_fee, phone)
├── patients (id, user_id, phone, dob, gender, address)
└── appointments (id, patient_id, doctor_id, appointment_date, appointment_time, status, diagnosis, prescription, created_at)
