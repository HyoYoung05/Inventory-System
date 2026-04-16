<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>

<style>
    .users-hierarchy-card .card-body {
        padding: 0.9rem;
    }

    .hierarchy-board {
        display: grid;
        gap: 0.75rem;
    }

    .hierarchy-tier {
        padding: 0.85rem;
        border-radius: 18px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        background: #fff;
    }

    .hierarchy-tier.admin-tier {
        background: linear-gradient(135deg, rgba(233, 69, 96, 0.12), rgba(255, 255, 255, 1));
    }

    .hierarchy-tier.staff-tier {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(255, 255, 255, 1));
    }

    .hierarchy-tier.user-tier {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.12), rgba(255, 255, 255, 1));
    }

    .hierarchy-tier h6 {
        margin-bottom: 0.65rem;
        font-weight: 800;
    }

    .hierarchy-list {
        display: grid;
        gap: 0.45rem;
    }

    .hierarchy-member {
        display: grid;
        gap: 0.2rem;
        padding: 0.65rem 0.8rem;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.86);
    }

    .hierarchy-member strong {
        color: #111827;
    }

    .hierarchy-member-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .hierarchy-member span {
        color: #6b7280;
        font-size: 0.88rem;
    }

    .hierarchy-empty {
        margin: 0;
        color: #6b7280;
    }
</style>

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3><i class="bi bi-people"></i> User Management</h3>
                <p class="text-muted mb-0">Create and review admin, staff, and user accounts.</p>
            </div>
            <a href="<?= site_url('admin/users/create') ?>" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Create User
            </a>
        </div>
    </div>
</div>

<div class="card mb-4 users-hierarchy-card">
    <div class="card-body">
        <div class="hierarchy-board">
            <section class="hierarchy-tier admin-tier">
                <h6><i class="bi bi-shield-lock me-2"></i>Admins</h6>
                <?php if (empty($hierarchyAdmins)): ?>
                    <p class="hierarchy-empty">No admin accounts found.</p>
                <?php else: ?>
                    <div class="hierarchy-list">
                        <?php foreach ($hierarchyAdmins as $member): ?>
                            <div class="hierarchy-member">
                                <strong><?= esc($member['username']) ?></strong>
                                <div class="hierarchy-member-meta">
                                    <span>Created: <?= date('M d, Y h:i A', strtotime($member['created_at'])) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <section class="hierarchy-tier staff-tier">
                <h6><i class="bi bi-person-workspace me-2"></i>Staff</h6>
                <?php if (empty($hierarchyStaff)): ?>
                    <p class="hierarchy-empty">No staff accounts found.</p>
                <?php else: ?>
                    <div class="hierarchy-list">
                        <?php foreach ($hierarchyStaff as $member): ?>
                            <div class="hierarchy-member">
                                <strong><?= esc($member['username']) ?></strong>
                                <div class="hierarchy-member-meta">
                                    <span>Created: <?= date('M d, Y h:i A', strtotime($member['created_at'])) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <section class="hierarchy-tier user-tier">
                <h6><i class="bi bi-people me-2"></i>Users</h6>
                <?php if (empty($hierarchyUsers)): ?>
                    <p class="hierarchy-empty">No buyer accounts found.</p>
                <?php else: ?>
                    <div class="hierarchy-list">
                        <?php foreach ($hierarchyUsers as $member): ?>
                            <div class="hierarchy-member">
                                <strong><?= esc($member['username']) ?></strong>
                                <div class="hierarchy-member-meta">
                                    <span>Created: <?= date('M d, Y h:i A', strtotime($member['created_at'])) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
