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

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= site_url('dashboard'); ?>">
                <i class="bi bi-hospital fs-3 me-2"></i> HMS Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3 text-white my-2 my-lg-0">
                        <i class="bi bi-person-circle me-1"></i>
                        <strong><?= html_escape($this->session->userdata('name')); ?></strong>
                        <span class="badge bg-light text-danger ms-1"><?= html_escape($this->session->userdata('role_name')); ?></span>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('auth/logout'); ?>" class="btn btn-light text-danger fw-semibold">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold text-dark mb-0"><i class="bi bi-person-gear text-danger me-2"></i>Account Settings</h3>
                    <a href="<?= site_url('dashboard'); ?>" class="btn btn-danger fw-semibold">
                        Go Back
                    </a>
                </div>

                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if(validation_errors()): ?>
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-exclamation-circle-fill me-2"></i><?= validation_errors(); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <form action="<?= site_url('profile/update'); ?>" method="POST">
                            
                            <h5 class="fw-bold text-danger border-bottom pb-2 mb-3">
                                <i class="bi bi-person-vcard me-2"></i>Basic Information
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <input type="text" name="name" class="form-control focus-ring focus-ring-danger" value="<?= set_value('name', $user->name ?? ''); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Email Address</label>
                                    <input type="email" name="email" class="form-control focus-ring focus-ring-danger" value="<?= set_value('email', $user->email ?? ''); ?>" required>
                                </div>
                            </div>

                            <?php $role_id = (int)$this->session->userdata('role_id'); ?>

                            <?php if($role_id === 2): ?>
                                <h5 class="fw-bold text-danger border-bottom pb-2 my-3">
                                    <i class="bi bi-stethoscope me-2"></i>Doctor Details
                                </h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold">Specialization</label>
                                        <input type="text" name="specialization" class="form-control focus-ring focus-ring-danger" value="<?= set_value('specialization', $user->specialization ?? ''); ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold">Consultation Fee (Rs.)</label>
                                        <input type="number" step="0.01" name="consultation_fee" class="form-control focus-ring focus-ring-danger" value="<?= set_value('consultation_fee', $user->fee ?? '0.00'); ?>">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if($role_id === 3): ?>
                                <h5 class="fw-bold text-danger border-bottom pb-2 my-3">
                                    <i class="bi bi-heart-pulse me-2"></i>Patient Details
                                </h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold">Contact Phone</label>
                                        <input type="tel" name="phone" class="form-control focus-ring focus-ring-danger" value="<?= set_value('phone', $user->phone ?? ''); ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold">Date of Birth</label>
                                        <input type="date" name="dob" class="form-control focus-ring focus-ring-danger" value="<?= set_value('dob', $user->dob ?? ''); ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold">Gender</label>
                                        <select name="gender" class="form-select focus-ring focus-ring-danger">
                                            <option value="">Select Gender</option>
                                            <option value="Male" <?= set_select('gender', 'Male', ($user->gender ?? '') === 'Male'); ?>>Male</option>
                                            <option value="Female" <?= set_select('gender', 'Female', ($user->gender ?? '') === 'Female'); ?>>Female</option>
                                            <option value="Other" <?= set_select('gender', 'Other', ($user->gender ?? '') === 'Other'); ?>>Other</option>
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <h5 class="fw-bold text-danger border-bottom pb-2 my-3">
                                <i class="bi bi-shield-lock me-2"></i>Security
                            </h5>
                            <p class="text-muted small mb-3">Leave blank if you do not wish to change your password.</p>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">New Password</label>
                                    <input type="password" name="password" class="form-control focus-ring focus-ring-danger" placeholder="••••••••">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Confirm New Password</label>
                                    <input type="password" name="confirm_password" class="form-control focus-ring focus-ring-danger" placeholder="••••••••">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="<?= site_url('dashboard'); ?>" class="btn btn-outline-danger fw-semibold">Cancel</a>
                                <button type="submit" class="btn btn-danger fw-semibold">Confirm</button>
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