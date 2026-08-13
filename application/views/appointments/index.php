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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-calendar-check-fill text-danger me-2"></i>Appointments Directory
            </h3>
            <div class="d-flex gap-2">
                <?php if((int)$this->session->userdata('role_id') === 3): ?>
                    <a href="<?= site_url('appointments/book'); ?>" class="btn btn-danger fw-semibold">
                        Book Appointment
                    </a>
                <?php endif; ?>
                <a href="<?= site_url('dashboard'); ?>" class="btn btn-outline-danger fw-semibold">
                    Go Back
                </a>
            </div>
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

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3">
                <form action="<?= site_url('appointments'); ?>" method="GET" class="row g-2 align-items-center">
                    <div class="col">
                        <select name="status" class="form-select focus-ring focus-ring-danger">
                            <option value="">All Statuses</option>
                            <option value="Pending" <?= ($status_filter === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="Completed" <?= ($status_filter === 'Completed') ? 'selected' : ''; ?>>Completed</option>
                            <option value="Cancelled" <?= ($status_filter === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-auto d-flex gap-2">
                        <?php if(empty($status_filter)): ?>
                            <button type="submit" class="btn btn-danger text-nowrap fw-semibold"><i class="bi bi-filter me-1"></i> Filter</button>
                        <?php else: ?>
                            <a href="<?= site_url('appointments'); ?>" class="btn btn-outline-danger text-nowrap fw-semibold"">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Patient Name</th>
                                <th>Doctor</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($appointments)): ?>
                                <?php foreach($appointments as $a): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">
                                            <i class="bi bi-person me-1 text-danger"></i><?= html_escape($a->patient_name); ?>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">Dr. <?= html_escape($a->doctor_name); ?></div>
                                            <span class="small text-muted"><?= html_escape($a->specialization ?? 'General'); ?></span>
                                        </td>
                                        <td>
                                            <div><i class="bi bi-calendar3 me-1 text-muted"></i><?= date('M d, Y', strtotime($a->appointment_date)); ?></div>
                                            <span class="small text-muted"><i class="bi bi-clock me-1"></i><?= date('h:i A', strtotime($a->appointment_time)); ?></span>
                                        </td>
                                        <td>
                                            <?php 
                                                $badge_class = 'bg-secondary-subtle text-dark border-dark';
                                                if($a->status === 'Completed') $badge_class = 'bg-success-subtle text-success border-success';
                                                if($a->status === 'Cancelled') $badge_class = 'bg-danger-subtle text-danger border-danger';
                                            ?>
                                            <span class="badge border <?= $badge_class; ?>"><?= $a->status; ?></span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-outline-danger me-1 btn-view-apt fw-semibold" data-id="<?= $a->id; ?>" data-bs-toggle="modal" data-bs-target="#viewModal">
                                                View
                                            </button>

                                            <?php if((int)$this->session->userdata('role_id') !== 3): ?>
                                                <button class="btn btn-sm btn-danger me-1 btn-edit-apt fw-semibold " 
                                                        data-id="<?= $a->id; ?>" 
                                                        data-status="<?= $a->status; ?>" 
                                                        data-diagnosis="<?= html_escape($a->diagnosis); ?>" 
                                                        data-prescription="<?= html_escape($a->prescription); ?>"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editModal">
                                                    Manage
                                                </button>
                                            <?php endif; ?>

                                            <?php if($a->status === 'Pending'): ?>
                                                <a href="<?= site_url('appointments/cancel/' . $a->id); ?>" class="btn btn-sm btn-danger fw-semibold" onclick="return confirm('Cancel this appointment?');">
                                                    Cancel
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-calendar-x fs-1 d-block mb-2 text-secondary"></i>
                                        No appointments found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-file-medical me-2"></i>Appointment Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" id="viewModalContent">
                    <div class="text-center py-4"><div class="spinner-border text-danger" role="status"></div></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Manage Record</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm" action="" method="POST">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Appointment Status</label>
                            <select name="status" id="editStatus" class="form-select" required>
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Diagnosis</label>
                            <textarea name="diagnosis" id="editDiagnosis" class="form-control" rows="3" placeholder="Enter clinical diagnosis..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Prescription / Notes</label>
                            <textarea name="prescription" id="editPrescription" class="form-control" rows="3" placeholder="Enter medicines, dosages, or notes..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger fw-semibold">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.btn-view-apt').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const container = document.getElementById('viewModalContent');
                container.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-danger" role="status"></div></div>';

                fetch(`<?= site_url('appointments/view_ajax/'); ?>${id}`)
                    .then(res => res.json())
                    .then(res => {
                        if(res.status === 'success') {
                            const a = res.data;
                            container.innerHTML = `
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex justify-content-between"><strong>Patient:</strong> <span>${a.patient_name}</span></li>
                                    <li class="list-group-item d-flex justify-content-between"><strong>Doctor:</strong> <span>Dr. ${a.doctor_name} (${a.specialization || 'General'})</span></li>
                                    <li class="list-group-item d-flex justify-content-between"><strong>Date & Time:</strong> <span>${a.appointment_date} @ ${a.appointment_time}</span></li>
                                    <li class="list-group-item d-flex justify-content-between"><strong>Status:</strong> <span class="fw-bold">${a.status}</span></li>
                                </ul>
                                <div class="p-3 bg-light rounded border mb-2">
                                    <strong class="d-block text-danger mb-1"><i class="bi bi-file-earmark-medical me-1"></i>Diagnosis:</strong>
                                    <p class="mb-0 text-muted small">${a.diagnosis || 'None entered yet.'}</p>
                                </div>
                                <div class="p-3 bg-light rounded border">
                                    <strong class="d-block text-danger mb-1"><i class="bi bi-capsule me-1"></i>Prescription:</strong>
                                    <p class="mb-0 text-muted small">${a.prescription || 'None entered yet.'}</p>
                                </div>
                            `;
                        }
                    });
            });
        });

        document.querySelectorAll('.btn-edit-apt').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('editForm').action = `<?= site_url('appointments/update/'); ?>${id}`;
                document.getElementById('editStatus').value = this.getAttribute('data-status');
                document.getElementById('editDiagnosis').value = this.getAttribute('data-diagnosis');
                document.getElementById('editPrescription').value = this.getAttribute('data-prescription');
            });
        });
    </script>
</body>
</html>