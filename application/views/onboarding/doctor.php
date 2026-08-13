<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthcare Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
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
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card shadow border-0 rounded-3">
                    <div class="card-header bg-danger text-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-person-workspace me-2"></i>Complete your Profile</h5>
                    </div>

                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center mb-2"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-hospital fs-3"></i>
                            </div>
                            <h4 class="fw-bold">Welcome, Dr. <?= html_escape($this->session->userdata('name')); ?>!</h4>
                            <p class="text-muted small">Please complete your profile to continue.</p>
                        </div>

                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>Please fix the following errors:
                                <div class="small mt-1"><?= validation_errors(); ?></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= site_url('/onboarding'); ?>" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Specialization</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="bi bi-award text-danger"></i></span>
                                    <input type="text" name="specialization"
                                        class="form-control focus-ring focus-ring-danger"
                                        placeholder="Enter your specialization"
                                        value="<?= set_value('specialization'); ?>" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">Consultation Fee (₹ INR)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white fw-bold text-danger">₹</span>
                                    <input type="number" step="0.01" min="0" name="fee"
                                        class="form-control focus-ring focus-ring-danger" placeholder="Enter the amount"
                                        value="<?= set_value('fee'); ?>" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-danger w-100 py-2 fw-bold">
                                Continue
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>