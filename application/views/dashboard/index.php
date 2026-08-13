<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthcare Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .action-card {
            border: none;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .bg-red-subtle {
            background-color: #f8d7da;
        }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= site_url('/dashboard'); ?>">
                <i class="bi bi-hospital fs-3 me-2"></i> HMS Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dashNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="dashNav">
                <ul class="navbar-nav ms-auto align-items-center">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2 pe-0" href="#"
                            id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span
                                class="fw-semibold text-white"><?= html_escape($this->session->userdata('name') ?? 'User'); ?></span>

                            <span class="badge bg-light text-danger fw-semibold" style="font-size: 0.75rem;">
                                <?= html_escape($this->session->userdata('role_name') ?? 'User'); ?>
                            </span>

                            <div class="rounded-circle bg-white text-danger d-flex align-items-center justify-content-center shadow-sm ms-1"
                                style="width: 38px; height: 38px; flex-shrink: 0;">
                                <i class="bi bi-person-fill fs-5"></i>
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center"
                                    href="<?= site_url('/profile'); ?>">
                                    <i class="bi bi-person-gear text-danger me-2 fs-5"></i> My Profile
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider my-1">
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center text-danger fw-semibold"
                                    href="<?= site_url('/auth/logout'); ?>">
                                    <i class="bi bi-box-arrow-right me-2 fs-5"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">

        <?php $role_id = (int) $this->session->userdata('role_id'); ?>

        <div class="row mb-5">
            <div class="col">
                <div class="p-4 bg-white rounded-3 shadow border-start border-4 border-danger">
                    <h2 class="fw-bold text-danger mb-1">
                        Welcome back,
                        <?= ($role_id === 2) ? 'Dr. ' : '' ?><?= html_escape($this->session->userdata('name') ?? 'User'); ?>!
                    </h2>
                    <p class="text-muted mb-0">Select a module below to get started.</p>
                </div>
            </div>
        </div>

        <div class="row g-4">

            <?php if ($role_id === 1 || $role_id === 2): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow action-card p-2">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-red-subtle text-danger d-inline-flex p-3 mb-3">
                                <i class="bi bi-people-fill fs-1"></i>
                            </div>
                            <h5 class="fw-bold">Patient Management</h5>
                            <p class="text-muted small">
                                <?= ($role_id === 1) ? 'Register new patients, manage demographic details, and oversee patient accounts.' : 'Access assigned patient medical histories, clinical records, and health profiles.'; ?>
                            </p>
                            <a href="<?= site_url('/patients'); ?>" class="btn btn-danger w-100 mt-2 fw-semibold">
                                <i class="bi bi-person-plus me-1"></i> Manage Patients
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($role_id === 1 || $role_id === 3): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow action-card p-2">
                        <div class="card-body text-center p-4">
                            <div class="rounded-circle bg-red-subtle text-danger d-inline-flex p-3 mb-3">
                                <i class="bi bi-person-badge-fill fs-1"></i>
                            </div>
                            <h5 class="fw-bold">Doctor List</h5>
                            <p class="text-muted small">
                                <?= ($role_id === 1) ? 'Add doctor profiles, update specializations, and manage consultation fee structures.' : 'Browse specialized doctors, view consultation fees, and select specialists for visits.'; ?>
                            </p>
                            <a href="<?= site_url('/doctors'); ?>" class="btn btn-outline-danger w-100 mt-2 fw-semibold">
                                <i class="bi bi-card-list me-1"></i> View Doctors
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-md-4">
                <div class="card h-100 shadow action-card p-2">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-red-subtle text-danger d-inline-flex p-3 mb-3">
                            <i class="bi bi-calendar-check-fill fs-1"></i>
                        </div>
                        <h5 class="fw-bold">Appointments</h5>
                        <p class="text-muted small">
                            <?php
                            if ($role_id === 2) {
                                echo 'View daily consultation queues, conduct visits, and generate digital prescriptions.';
                            } else if ($role_id === 3) {
                                echo 'Book new doctor consultations, view upcoming appointments, and track past visits.';
                            } else {
                                echo 'Monitor hospital-wide consultation schedules and oversee booking activity.';
                            }
                            ?>
                        </p>
                        <a href="<?= site_url('/appointments'); ?>"
                            class="btn btn-outline-danger w-100 mt-2 fw-semibold">
                            <i class="bi bi-calendar-plus me-1"></i>
                            <?= ($role_id === 3) ? 'Book / View Appointments' : 'Manage Appointments'; ?>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>