<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthcare Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
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

    <!-- Top Navigation Bar -->
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
                    <li class="nav-item me-3 text-white my-2 my-lg-0">
                        <i class="bi bi-person-circle me-1"></i>
                        <strong><?= html_escape($name ?? 'User'); ?></strong>
                        <span class="badge bg-light text-danger ms-1"><?= html_escape($role_name ?? 'Patient'); ?></span>
                    </li>

                    <li class="nav-item">
                        <a href="<?= site_url('/auth/logout'); ?>" class="btn btn-outline-light btn-sm fw-semibold">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">

        <div class="row mb-5">
            <div class="col">
                <div class="p-4 bg-white rounded-3 shadow-sm border-start border-4 border-danger">
                    <h2 class="fw-bold text-danger mb-1">Welcome back, <?= html_escape($name ?? 'User'); ?>!</h2>
                    <p class="text-muted mb-0">Select a module below to get started.</p>
                </div>
            </div>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card h-100 shadow-sm action-card p-2">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-red-subtle text-danger d-inline-flex p-3 mb-3">
                            <i class="bi bi-people-fill fs-1"></i>
                        </div>
                        <h5 class="fw-bold">Patient Management</h5>
                        <p class="text-muted small">Register new patients, edit demographic records, and view medical histories.</p>
                        <a href="<?= site_url('/patients'); ?>" class="btn btn-danger w-100 mt-2 fw-semibold">
                            <i class="bi bi-person-plus me-1"></i> Manage Patients
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm action-card p-2">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-red-subtle text-danger d-inline-flex p-3 mb-3">
                            <i class="bi bi-person-badge-fill fs-1"></i>
                        </div>
                        <h5 class="fw-bold">Doctor List</h5>
                        <p class="text-muted small">View registered doctor profiles, consultation fees, and availability.</p>
                        <a href="<?= site_url('/doctors'); ?>" class="btn btn-outline-danger w-100 mt-2 fw-semibold">
                            <i class="bi bi-card-list me-1"></i> View Doctors
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm action-card p-2">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-red-subtle text-danger d-inline-flex p-3 mb-3">
                            <i class="bi bi-calendar-check-fill fs-1"></i>
                        </div>
                        <h5 class="fw-bold">Appointments</h5>
                        <p class="text-muted small">Book patient consultations, write digital prescriptions, and view diagnosis histories.</p>
                        <a href="<?= site_url('/appointments'); ?>" class="btn btn-outline-danger w-100 mt-2 fw-semibold">
                            <i class="bi bi-calendar-plus me-1"></i> Appointments
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>