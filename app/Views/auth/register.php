<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Inventory System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('css/inventory-ui.css') ?>" rel="stylesheet">
    <style>
        body.inventory-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .auth-container {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .auth-container::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            top: -50px;
            left: -50px;
        }

        .auth-container::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            bottom: -30px;
            right: -30px;
        }

        .auth-card {
            width: min(460px, calc(100% - 1rem));
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1;
        }

        .auth-header {
            text-align: center;
            padding: 40px 30px 20px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .auth-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--teal);
            margin: 0 0 8px;
        }

        .auth-header p {
            color: #667085;
            font-size: 14px;
            margin: 0;
        }

        .auth-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .form-control {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: #fff;
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(20, 130, 122, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--teal) 0%, #1d6fb1 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(20, 130, 122, 0.3);
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 12px 15px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: #ffebee;
            color: #c62828;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert-danger li {
            margin-bottom: 5px;
        }

        .auth-footer {
            text-align: center;
            padding: 20px 30px 30px;
            font-size: 14px;
            color: #666;
        }

        .auth-footer a {
            color: var(--teal);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="inventory-shell">
    <div class="page-orb orb-one"></div>
    <div class="page-orb orb-two"></div>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2><i class="bi bi-box-seam"></i> Inventory</h2>
                <p>Create an account and choose whether it should be admin or staff</p>
            </div>
            <div class="auth-body">
                <?php if (session()->get('success')): ?>
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i> <?= session()->get('success') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->get('errors')): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session()->get('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form action="<?= site_url('auth/register') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="username"><i class="bi bi-person"></i> Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>" placeholder="Choose a username" required>
                    </div>
                    <div class="form-group">
                        <label for="role"><i class="bi bi-person-badge"></i> Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="">Select a role</option>
                            <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="staff" <?= old('role') === 'staff' ? 'selected' : '' ?>>Staff</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="bi bi-lock"></i> Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="At least 8 characters" required>
                    </div>
                    <div class="form-text mb-3">Choose a role before creating the account. You will be signed in right away after registration.</div>
                    <button type="submit" class="btn btn-login">Create Account</button>
                </form>
            </div>
            <div class="auth-footer">
                Already have an account? <a href="<?= site_url('login') ?>">Sign in</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
