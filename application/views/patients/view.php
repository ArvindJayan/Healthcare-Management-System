<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile - <?= html_escape($patient->name); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="<?= site_url('/dashboard'); ?>">
      <i class="bi bi-hospital me-2"></i>HMS Portal
    </a>
    <div class="navbar-nav ms-auto">
      <span class="nav-link text-white me-3">Welcome, <?= html_escape($this->session->userdata('name')); ?></span>
      <a class="btn btn-outline-light btn-sm" href="<?= site_url('/auth/logout'); ?>">Logout</a>
    </div>
  </div>
</nav>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?= $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-danger text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-badge me-2"></i>Patient Profile</h5>
                    
                    <div>
                        <a href="<?= site_url('/patients/edit/' . $patient->id); ?>" class="btn btn-light btn-sm text-danger fw-bold">
                            <i class="bi bi-pencil me-1"></i> Edit Profile
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        
                        <div class="col-12 d-flex align-items-center bg-light p-3 rounded border">
                            <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; font-size: 24px;">
                                <i class="bi bi-person"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold"><?= html_escape($patient->name); ?></h4>
                                <span class="badge bg-secondary me-2">Patient ID: #<?= $patient->id; ?></span>
                                <span class="badge bg-danger-subtle text-danger border border-danger">
                                    Blood Group: <?= html_escape($patient->blood_group) ?: 'Not Specified'; ?>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold">Email Address</label>
                            <p class="fs-6 fw-semibold mb-0 text-dark"><i class="bi bi-envelope me-2 text-danger"></i><?= html_escape($patient->email); ?></p>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold">Phone Number</label>
                            <p class="fs-6 fw-semibold mb-0 text-dark"><i class="bi bi-telephone me-2 text-danger"></i><?= html_escape($patient->phone); ?></p>
                        </div>

                        <hr class="my-2 text-muted">

                        <div class="col-md-4">
                            <label class="text-muted small text-uppercase fw-bold">Gender</label>
                            <p class="fs-6 mb-0 text-dark"><?= html_escape($patient->gender); ?></p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted small text-uppercase fw-bold">Date of Birth</label>
                            <p class="fs-6 mb-0 text-dark"><?= date('F d, Y', strtotime($patient->dob)); ?></p>
                        </div>

                        <div class="col-md-4">
                            <label class="text-muted small text-uppercase fw-bold">Age</label>
                            <p class="fs-6 mb-0 text-dark">
                                <?php 
                                    $dob = new DateTime($patient->dob);
                                    $now = new DateTime();
                                    echo $now->diff($dob)->y . ' years old';
                                ?>
                            </p>
                        </div>

                        <hr class="my-2 text-muted">

                        <div class="col-12">
                            <label class="text-muted small text-uppercase fw-bold">Address</label>
                            <p class="fs-6 mb-0 text-dark">
                                <i class="bi bi-geo-alt me-1 text-danger"></i>
                                <?= html_escape($patient->address) ?: '<em class="text-muted">No address provided.</em>'; ?>
                            </p>
                        </div>

                        <hr class="my-2 text-muted">

                        <div class="col-12">
                            <label class="text-muted small text-uppercase fw-bold mb-2">Medical History & Notes</label>
                            <div class="p-3 bg-light rounded border">
                                <?php if (!empty($patient->medical_history)): ?>
                                    <p class="mb-0 text-dark" style="white-space: pre-line;"><?= html_escape($patient->medical_history); ?></p>
                                <?php else: ?>
                                    <em class="text-muted">No medical history recorded.</em>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer bg-white py-3">
                    <a href="<?= site_url('/patients'); ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Back to Patient Directory
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>