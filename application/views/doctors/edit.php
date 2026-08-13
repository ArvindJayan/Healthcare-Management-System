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

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-dark mb-0"><i class="bi bi-pencil-square text-danger me-2"></i>Edit Doctor Record</h4>
                    <a href="<?= site_url('doctors'); ?>" class="btn btn-outline-danger fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Back to Directory
                    </a>
                </div>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-danger text-white py-3">
                        <h5 class="mb-0 fw-bold">Dr. <?= html_escape($doctor->name); ?></h5>
                    </div>

                    <div class="card-body p-4">

                        <?php if(validation_errors()): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>Please fix the following errors:
                                <div class="small mt-1"><?= validation_errors(); ?></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= site_url('doctors/edit/' . $doctor->id); ?>" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name" class="form-control focus-ring focus-ring-danger" value="<?= set_value('name', $doctor->name); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Specialization</label>
                                <input type="text" name="specialization" class="form-control focus-ring focus-ring-danger" value="<?= set_value('specialization', $doctor->specialization); ?>" required placeholder="e.g. Cardiology, Pediatrics">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Consultation Fee ($)</label>
                                    <input type="number" 
                                        step="0.01" 
                                        name="consultation_fee" 
                                        class="form-control" 
                                        value="<?= set_value('consultation_fee', $doctor->consultation_fee ?? $doctor->fee ?? '0.00'); ?>" 
                                        required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="<?= site_url('doctors'); ?>" class="btn btn-outline-danger fw-semibold">Cancel</a>
                                <button type="submit" class="btn btn-danger fw-semibold"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>