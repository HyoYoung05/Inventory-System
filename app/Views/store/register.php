<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Register - Inventory Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('css/inventory-ui.css') ?>" rel="stylesheet">
    <style>
        body.inventory-shell { min-height: 100vh; display: flex; align-items: center; }
        .auth-container { min-height: 100vh; width: 100%; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
        .auth-card { width: min(460px, calc(100% - 1rem)); background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); border-radius: 20px; box-shadow: 0 8px 32px rgba(0,0,0,0.1); position: relative; z-index: 1; }
        .auth-header { text-align: center; padding: 40px 30px 20px; border-bottom: 1px solid rgba(0,0,0,0.05); }
        .auth-header h2 { font-size: 28px; font-weight: 700; color: var(--teal); margin: 0 0 8px; }
        .auth-header p { color: #667085; font-size: 14px; margin: 0; }
        .auth-body { padding: 40px 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; color: #333; margin-bottom: 10px; font-size: 14px; }
        .form-control { background: #f8f9fa; border: 2px solid #e9ecef; border-radius: 10px; padding: 12px 15px; font-size: 14px; transition: all 0.3s ease; }
        .form-control:focus { background: #fff; border-color: var(--teal); box-shadow: 0 0 0 3px rgba(20,130,122,0.1); }
        .btn-login { width: 100%; padding: 12px; background: linear-gradient(135deg, var(--teal) 0%, #1d6fb1 100%); border: none; border-radius: 10px; color: white; font-weight: 600; font-size: 16px; cursor: pointer; transition: all 0.3s ease; }
        .alert { border-radius: 10px; border: none; padding: 12px 15px; font-size: 14px; margin-bottom: 20px; }
        .alert-danger { background: #ffebee; color: #c62828; }
        .alert-danger ul { margin: 0; padding-left: 20px; }
        .auth-footer { text-align: center; padding: 20px 30px 30px; font-size: 14px; color: #666; }
        .auth-footer a { color: var(--teal); text-decoration: none; font-weight: 600; }
    </style>
</head>
<body class="inventory-shell">
    <div class="page-orb orb-one"></div>
    <div class="page-orb orb-two"></div>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2><i class="bi bi-bag-plus"></i> Buyer Account</h2>
                <p>Create a buyer account for the storefront</p>
            </div>
            <div class="auth-body">
                <?php if (session()->get('errors')): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session()->get('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form action="<?= site_url('buyer/register') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="first_name"><i class="bi bi-person-vcard"></i> First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= old('first_name') ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="last_name"><i class="bi bi-person-vcard-fill"></i> Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= old('last_name') ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="bi bi-envelope"></i> Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username"><i class="bi bi-person"></i> Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>" placeholder="Choose a username" required>
                    </div>
                    <div class="form-group">
                        <label for="contact"><i class="bi bi-telephone"></i> Contact</label>
                        <div class="row g-2">
                            <div class="col-md-5">
                                <select class="form-control" id="phone_code" name="phone_code" required>
                                    <option value="">Code</option>
                                    <?php foreach (($phoneCodes ?? []) as $code => $label): ?>
                                        <option value="<?= esc($code) ?>" <?= old('phone_code', '+63') === $code ? 'selected' : '' ?>>
                                            <?= esc($label) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="contact" name="contact" value="<?= esc(old('contact')) ?>" placeholder="Phone number" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="bi bi-lock"></i> Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="At least 8 characters" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="date_of_birth"><i class="bi bi-calendar-event"></i> Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?= old('date_of_birth') ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="zip_code"><i class="bi bi-mailbox"></i> Zip Code</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" value="<?= old('zip_code') ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address"><i class="bi bi-geo-alt"></i> Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required><?= old('address') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="country"><i class="bi bi-globe"></i> Country</label>
                        <select class="form-control" id="country" name="country" required>
                            <option value="">Select a country</option>
                            <?php foreach (($countries ?? []) as $country): ?>
                                <option value="<?= esc($country) ?>" <?= old('country') === $country ? 'selected' : '' ?>>
                                    <?= esc($country) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-text mb-3">This registration creates a buyer account only.</div>
                    <button type="submit" class="btn btn-login">Create Buyer Account</button>
                </form>
            </div>
            <div class="auth-footer">
                Already have a buyer account? <a href="<?= site_url('buyer/login') ?>">Sign in</a>
            </div>
        </div>
    </div>
</body>
</html>
