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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark mb-0">
                <i class="bi bi-people-fill text-danger me-2"></i>Patient Management
            </h3>
            <a href="<?= site_url('dashboard'); ?>" class="btn btn-outline-danger fw-semibold">
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

<div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3">
                <form action="<?= site_url('patients'); ?>" method="GET" class="row g-2 align-items-center">
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control focus-ring focus-ring-danger" placeholder="Search..." value="<?= html_escape($search); ?>">
                        </div>
                    </div>
                    <div class="col-md-auto d-flex gap-2">
                        <?php if(empty($search)): ?>
                            <button type="submit" class="btn btn-danger text-nowrap fw-semibold">
                                <i class="bi bi-search me-1"></i> Search
                            </button>
                        <?php else: ?>
                            <a href="<?= site_url('patients'); ?>" class="btn btn-danger text-nowrap fw-semibold">
                                <i class="bi bi-x-circle me-1"></i> Reset
                            </a>
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
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Date of Birth</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($patients)): ?>
                                <?php foreach($patients as $p): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">
                                            <i class="bi bi-person-square text-danger me-2"></i><?= html_escape($p->name); ?>
                                        </td>
                                        <td><?= html_escape($p->email); ?></td>
                                        <td><?= html_escape($p->phone); ?></td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-dark border">
                                                <?= html_escape($p->gender); ?>
                                            </span>
                                        </td>
                                        <td><?= date('M d, Y', strtotime($p->dob)); ?></td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-outline-danger me-1 btn-view-patient" data-id="<?= $p->id; ?>" data-bs-toggle="modal" data-bs-target="#viewPatientModal">
                                                View
                                            </button>
                                            <a href="<?= site_url('patients/edit/' . $p->id); ?>" class="btn btn-sm btn-danger">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
                                        No patient records found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewPatientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-vcard me-2"></i>Patient Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" id="modalPatientContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-danger" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.btn-view-patient').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const container = document.getElementById('modalPatientContent');
                
                container.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-danger" role="status"></div></div>';

                fetch(`<?= site_url('patients/view_ajax/'); ?>${id}`)
                    .then(res => res.json())
                    .then(res => {
                        if(res.status === 'success') {
                            const p = res.data;
                            container.innerHTML = `
                                <div class="text-center mb-3">
                                    <div class="rounded-circle bg-danger-subtle text-danger d-inline-flex p-3 mb-2">
                                        <i class="bi bi-person fs-1"></i>
                                    </div>
                                    <h4 class="fw-bold mb-0">${p.name}</h4>
                                    <span class="text-muted small">${p.email}</span>
                                </div>
                                <ul class="list-group list-group-flush border-top border-bottom my-3">
                                    <li class="list-group-item d-flex justify-content-between"><strong>Phone:</strong> <span>${p.phone}</span></li>
                                    <li class="list-group-item d-flex justify-content-between"><strong>Gender:</strong> <span>${p.gender}</span></li>
                                    <li class="list-group-item d-flex justify-content-between"><strong>Date of Birth:</strong> <span>${p.dob}</span></li>
                                    <li class="list-group-item d-flex justify-content-between"><strong>Age:</strong> <span>${p.age} years old</span></li>
                                    <li class="list-group-item d-flex justify-content-between"><strong>Registered Since:</strong> <span>${p.registered_since}</span></li>
                                </ul>
                            `;
                        } else {
                            container.innerHTML = `<div class="alert alert-danger mb-0">${res.message}</div>`;
                        }
                    });
            });
        });
    </script>
</body>
</html>