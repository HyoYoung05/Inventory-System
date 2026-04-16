<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('css/inventory-ui.css') ?>" rel="stylesheet">
    <style>
        body.inventory-shell {
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }

        .auth-stage {
            position: relative;
            z-index: 1;
            width: min(1120px, calc(100% - 2rem));
            margin: 0 auto;
        }

        .auth-shell {
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(360px, 0.9fr);
            border: 1px solid rgba(19, 34, 56, 0.08);
            border-radius: 34px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(18px);
            box-shadow: 0 32px 90px rgba(20, 35, 57, 0.16);
        }

        .auth-hero {
            position: relative;
            padding: 3.5rem;
            background:
                radial-gradient(circle at top right, rgba(243, 176, 74, 0.22), transparent 32%),
                linear-gradient(160deg, rgba(19, 34, 56, 0.98), rgba(24, 51, 81, 0.94));
            color: #fff;
            overflow: hidden;
        }

        .auth-hero::after {
            content: "";
            position: absolute;
            inset: auto -5rem -5rem auto;
            width: 18rem;
            height: 18rem;
            border-radius: 50%;
            background: rgba(20, 130, 122, 0.16);
            filter: blur(10px);
        }

        .hero-brand {
            display: inline-flex;
            align-items: center;
            gap: 0.9rem;
            margin-bottom: 2.2rem;
        }

        .hero-brand-icon {
            display: inline-grid;
            place-items: center;
            width: 3.25rem;
            height: 3.25rem;
            border-radius: 1.2rem;
            background: linear-gradient(145deg, #18b1a7, #f3b04a);
            color: #102033;
            font-size: 1.35rem;
        }

        .hero-brand-copy strong,
        .hero-brand-copy span {
            display: block;
            line-height: 1.1;
        }

        .hero-brand-copy strong {
            font-family: var(--font-display);
            font-size: 1.1rem;
            letter-spacing: 0.02em;
        }

        .hero-brand-copy span {
            color: rgba(255, 255, 255, 0.68);
            font-size: 0.88rem;
        }

        .hero-eyebrow {
            display: inline-block;
            margin-bottom: 1rem;
            color: #8fe2db;
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .auth-hero h1 {
            max-width: 11ch;
            margin-bottom: 1rem;
            font-family: var(--font-display);
            font-size: clamp(2.7rem, 5vw, 4.8rem);
            line-height: 0.96;
            letter-spacing: -0.05em;
        }

        .hero-copy {
            max-width: 34rem;
            margin-bottom: 2rem;
            padding: 1rem 1.1rem;
            border-radius: 1rem;
            background: rgba(243, 176, 74, 0.12);
            color: rgba(255, 255, 255, 0.76);
            font-size: 1.02rem;
        }

        .hero-highlights {
            display: grid;
            gap: 0.9rem;
            margin-bottom: 2rem;
        }

        .hero-highlight {
            display: grid;
            grid-template-columns: 2.8rem 1fr;
            gap: 0.9rem;
            align-items: start;
            padding: 1rem 1.05rem;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.15rem;
            background: rgba(255, 255, 255, 0.06);
        }

        .hero-highlight-icon {
            display: inline-grid;
            place-items: center;
            width: 2.8rem;
            height: 2.8rem;
            border-radius: 0.95rem;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 1rem;
        }

        .hero-highlight strong {
            display: block;
            margin-bottom: 0.2rem;
            font-size: 0.98rem;
        }

        .hero-highlight span {
            color: rgba(255, 255, 255, 0.68);
            font-size: 0.9rem;
        }

        .hero-footer {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.95rem 1.05rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.88);
            font-size: 0.92rem;
        }

        .hero-footer i {
            color: #f7c85e;
        }

        .auth-panel {
            padding: 3rem;
            background: rgba(255, 255, 255, 0.9);
        }

        .auth-panel-header {
            margin-bottom: 1.8rem;
        }

        .auth-panel-header h2 {
            margin-bottom: 0.5rem;
            font-family: var(--font-display);
            font-size: 2rem;
            letter-spacing: -0.04em;
            color: var(--ink);
        }

        .auth-panel-header p {
            margin: 0;
            color: var(--ink-soft);
        }

        .alert-login {
            border: 1px solid rgba(212, 93, 63, 0.18);
            border-radius: 1rem;
            background: rgba(212, 93, 63, 0.08);
            color: #9d4029;
        }

        .form-label {
            margin-bottom: 0.55rem;
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--ink);
        }

        .input-shell {
            position: relative;
        }

        .input-shell i {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            color: var(--ink-soft);
            font-size: 0.98rem;
        }

        .input-shell .form-control {
            min-height: 3.55rem;
            padding: 0.95rem 1rem 0.95rem 2.8rem;
            border: 1px solid rgba(19, 34, 56, 0.12);
            border-radius: 1.15rem;
            background: #fff;
            color: var(--ink);
            box-shadow: none;
        }

        .input-shell .form-control:focus {
            border-color: rgba(20, 130, 122, 0.48);
            box-shadow: 0 0 0 0.25rem rgba(20, 130, 122, 0.12);
        }

        .btn-login {
            width: 100%;
            min-height: 3.65rem;
            border: 0;
            border-radius: 1.2rem;
            background: linear-gradient(135deg, var(--teal), #1d6fb1);
            color: #fff;
            font-weight: 800;
            letter-spacing: 0.02em;
            box-shadow: 0 18px 34px rgba(20, 130, 122, 0.24);
            transition: transform 0.24s ease, box-shadow 0.24s ease;
        }

        .btn-login:hover,
        .btn-login:focus {
            transform: translateY(-2px);
            box-shadow: 0 24px 40px rgba(20, 130, 122, 0.28);
            color: #fff;
        }

        .auth-caption {
            margin-top: 1.2rem;
            color: var(--ink-soft);
            font-size: 0.88rem;
            text-align: center;
        }

        .reveal-delay-1 {
            animation-delay: 0.08s;
        }

        .reveal-delay-2 {
            animation-delay: 0.16s;
        }

        @media (max-width: 991.98px) {
            .auth-shell {
                grid-template-columns: 1fr;
            }

            .auth-hero,
            .auth-panel {
                padding: 2.25rem;
            }

            .auth-hero h1 {
                max-width: none;
            }
        }

        @media (max-width: 575.98px) {
            body.inventory-shell {
                padding: 1rem 0;
            }

            .auth-stage {
                width: calc(100% - 1rem);
            }

            .auth-hero,
            .auth-panel {
                padding: 1.5rem;
            }

            .hero-highlight {
                grid-template-columns: 1fr;
            }

            .hero-highlight-icon {
                width: 2.5rem;
                height: 2.5rem;
            }

        }
    </style>
</head>
<body class="inventory-shell">
    <div class="page-orb orb-one"></div>
    <div class="page-orb orb-two"></div>

    <main class="auth-stage">
        <section class="auth-shell reveal-up">
            <div class="auth-hero reveal-up reveal-delay-1">
                <div class="hero-brand">
                    <div class="hero-brand-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="hero-brand-copy">
                        <strong>Inventory System</strong>
                        <span>Operations dashboard</span>
                    </div>
                </div>

                <span class="hero-eyebrow">Inventory Control</span>
                <h1>Move stock with clarity.</h1>
                <p class="hero-copy">
                    A cleaner workspace for tracking products, managing orders, and keeping your team aligned from the first login.
                </p>

                <div class="hero-highlights">
                    <div class="hero-highlight">
                        <div class="hero-highlight-icon">
                            <i class="bi bi-grid-1x2"></i>
                        </div>
                        <div>
                            <strong>Simple daily workflow</strong>
                            <span>Products, categories, and orders are easy to reach and easy to manage.</span>
                        </div>
                    </div>
                    <div class="hero-highlight">
                        <div class="hero-highlight-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <strong>Role-based access</strong>
                            <span>Secure sign-in for admin, staff, and user accounts in one streamlined entry point.</span>
                        </div>
                    </div>
                </div>

                <div class="hero-footer">
                    <i class="bi bi-stars"></i>
                    <span>Designed to feel professional on first impression and practical in everyday use.</span>
                </div>
            </div>

            <div class="auth-panel reveal-up reveal-delay-2">
                <div class="auth-panel-header">
                    <h2>Welcome back</h2>
                    <p>Sign in to continue to your inventory workspace.</p>
                </div>

                <?php if (session()->getFlashdata('msg')): ?>
                    <div class="alert alert-login mb-4" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i><?= session()->getFlashdata('msg') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('login/authenticate') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-shell">
                            <i class="bi bi-person"></i>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" value="<?= esc(old('username')) ?>" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-shell">
                            <i class="bi bi-lock"></i>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                    </button>
                </form>

                <p class="auth-caption mb-2">
                    Clean interface. Stronger presentation. Same login flow underneath.
                </p>
                <p class="auth-caption mb-0">
                    New here? <a href="<?= site_url('register') ?>">Create a user account</a>
                </p>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
