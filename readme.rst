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
