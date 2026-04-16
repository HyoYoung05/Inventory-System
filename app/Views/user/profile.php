<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('content') ?>

<style>
    .profile-shell {
        display: grid;
        grid-template-columns: minmax(0, 1.45fr) minmax(280px, 0.85fr);
        gap: 1.5rem;
    }

    .profile-card {
        padding: 1.4rem;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
    }

    .profile-heading {
        margin-bottom: 1rem;
    }

    .profile-heading h3 {
        margin-bottom: 0.35rem;
        font-family: 'Space Grotesk', 'Manrope', sans-serif;
        font-weight: 700;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .profile-grid .full {
        grid-column: 1 / -1;
    }

    .profile-card .form-control {
        min-height: 3rem;
        border-radius: 14px;
    }

    .password-panel {
        margin-top: 1.5rem;
        padding: 1.15rem;
        border-radius: 18px;
        background: linear-gradient(135deg, #f8fafc, #eef2ff);
        border: 1px solid rgba(37, 99, 235, 0.08);
    }

    .password-panel h5 {
        margin-bottom: 0.35rem;
        font-weight: 800;
    }

    .order-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.75rem;
        padding: 0.95rem 0;
        border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        color: inherit;
        text-decoration: none;
    }

    .order-link:last-child {
        border-bottom: 0;
    }

    @media (max-width: 991.98px) {
        .profile-shell {
            grid-template-columns: 1fr;
        }

        .profile-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="profile-shell">
    <section class="profile-card">
        <div class="profile-heading">
            <h3>My Profile</h3>
            <p class="text-muted mb-0">Edit your buyer information here, then jump to your orders or category browsing whenever you need it.</p>
        </div>

        <?php if (session()->get('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->get('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= site_url('user/profile/update') ?>">
            <?= csrf_field() ?>
            <div class="profile-grid">
                <div>
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="<?= esc(old('first_name', $user['first_name'] ?? '')) ?>" required>
                </div>
                <div>
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="<?= esc(old('last_name', $user['last_name'] ?? '')) ?>" required>
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= esc(old('email', $user['email'] ?? '')) ?>" required>
                </div>
                <div>
                    <label class="form-label">Contact</label>
                    <input type="text" name="contact" class="form-control" value="<?= esc(old('contact', $user['contact'] ?? '')) ?>" required>
                </div>
                <div>
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" value="<?= esc($user['username'] ?? '') ?>" disabled>
                </div>
                <div>
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control" value="<?= esc(old('date_of_birth', $user['date_of_birth'] ?? '')) ?>" required>
                </div>
                <div class="full">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="3" required><?= esc(old('address', $user['address'] ?? '')) ?></textarea>
                </div>
                <div>
                    <label class="form-label">Zip Code</label>
                    <input type="text" name="zip_code" class="form-control" value="<?= esc(old('zip_code', $user['zip_code'] ?? '')) ?>" required>
                </div>
                <div>
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control" value="<?= esc(old('country', $user['country'] ?? '')) ?>" required>
                </div>
            </div>

            <div class="password-panel">
                <h5>Change Password</h5>
                <p class="text-muted mb-3">Leave these fields blank if you only want to update your profile details.</p>
                <div class="profile-grid">
                    <div class="full">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" autocomplete="current-password">
                    </div>
                    <div>
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" autocomplete="new-password">
                    </div>
                    <div>
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control" autocomplete="new-password">
                    </div>
                </div>
                <div class="small text-muted mt-2">Use at least 8 characters for your new password.</div>
            </div>

            <div class="mt-4 d-flex gap-2 flex-wrap">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check2-circle me-2"></i>Save Changes
                </button>
                <a href="<?= site_url('user/categories') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-grid-3x3-gap me-2"></i>Browse Categories
                </a>
                <a href="<?= site_url('user/orders') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-bag me-2"></i>Manage Orders
                </a>
            </div>
        </form>
    </section>

    <aside class="profile-card">
        <div class="profile-heading">
            <h3>Recent Orders</h3>
            <p class="text-muted mb-0">Quick access to your latest purchases.</p>
        </div>

        <?php if (empty($recentOrders)): ?>
            <p class="text-muted mb-0">You have not placed any orders yet.</p>
        <?php else: ?>
            <?php foreach ($recentOrders as $order): ?>
                <a href="<?= site_url('user/orders/details/' . $order['id']) ?>" class="order-link">
                    <div>
                        <div class="fw-bold">Order #<?= (int) $order['id'] ?></div>
                        <div class="small text-muted"><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold">&#8369;<?= number_format((float) $order['total_amount'], 2) ?></div>
                        <div class="small text-muted"><?= esc(ucwords(str_replace('_', ' ', $order['status']))) ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </aside>
</div>

<?= $this->endSection() ?>
