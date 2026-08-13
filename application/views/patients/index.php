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

<nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="<?= site_url('/dashboard'); ?>"><i class="bi bi-hospital me-2"></i>HMS Portal</a>
    <div class="navbar-nav ms-auto">
      <span class="nav-link text-white me-3">Welcome, <?= $this->session->userdata('name'); ?></span>
      <a class="btn btn-light text-danger fw-medium" href="<?= site_url('/auth/logout'); ?>">Logout</a>
    </div>
  </div>
</nav>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-dark"><i class="bi bi-people me-2"></i>Patient Directory</h3>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Search Bar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="<?= site_url('/patients'); ?>" method="GET" class="row g-2">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control focus-ring focus-ring-danger" placeholder="Search by Name, Email, or Phone..." value="<?= html_escape($search); ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-danger fw-medium w-100"><i class="bi bi-search me-1"></i> Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-danger">
                        <tr>
                            <th># ID</th>
                            <th>Full Name</th>
                            <th>Email Address</th>
                            <th>Phone</th>
                            <th>Gender / DOB</th>
                            <th>Blood Group</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($patients)): ?>
                            <?php foreach($patients as $patient): ?>
                                <tr>
                                    <td><span class="badge bg-secondary">#<?= $patient->id; ?></span></td>
                                    <td class="fw-semibold"><?= $patient->name; ?></td>
                                    <td><?= $patient->email; ?></td>
                                    <td><?= $patient->phone; ?></td>
                                    <td><?= $patient->gender; ?> <small class="text-muted">(<?= date('M d, Y', strtotime($patient->dob)); ?>)</small></td>
                                    <td>
                                        <span class="badge bg-danger-subtle text-danger border border-danger">
                                            <?= $patient->blood_group ?: 'N/A'; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= site_url('/patients/view/' . $patient->id); ?>" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-eye"></i> View Profile
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No registered patients found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <small class="text-muted">Showing <?= count($patients); ?> records</small>
            <?= $pagination; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>