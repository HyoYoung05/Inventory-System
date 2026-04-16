<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Login - Inventory Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('css/inventory-ui.css') ?>" rel="stylesheet">
    <style>
        body.inventory-shell { display: flex; align-items: center; padding: 2rem 0; }
        .auth-stage { position: relative; z-index: 1; width: min(1120px, calc(100% - 2rem)); margin: 0 auto; }
        .auth-shell { display: grid; grid-template-columns: minmax(0, 1.05fr) minmax(360px, 0.95fr); border: 1px solid rgba(19, 34, 56, 0.08); border-radius: 34px; overflow: hidden; background: rgba(255, 255, 255, 0.72); backdrop-filter: blur(18px); box-shadow: 0 32px 90px rgba(20, 35, 57, 0.16); }
        .auth-hero { padding: 3.25rem; background: radial-gradient(circle at top right, rgba(243, 176, 74, 0.22), transparent 32%), linear-gradient(160deg, rgba(19, 34, 56, 0.98), rgba(24, 51, 81, 0.94)); color: #fff; }
        .hero-brand { display: inline-flex; align-items: center; gap: 0.9rem; margin-bottom: 2rem; }
        .hero-brand-icon { display: inline-grid; place-items: center; width: 3.25rem; height: 3.25rem; border-radius: 1.2rem; background: linear-gradient(145deg, #18b1a7, #f3b04a); color: #102033; font-size: 1.35rem; }
        .hero-eyebrow { display: inline-block; margin-bottom: 1rem; color: #8fe2db; font-size: 0.78rem; font-weight: 800; letter-spacing: 0.16em; text-transform: uppercase; }
        .auth-hero h1 { max-width: 12ch; margin-bottom: 1rem; font-family: "Space Grotesk", sans-serif; font-size: clamp(2.5rem, 5vw, 4.5rem); line-height: 0.96; letter-spacing: -0.05em; }
        .hero-copy { max-width: 34rem; margin-bottom: 2rem; padding: 1rem 1.1rem; border-radius: 1rem; background: rgba(243, 176, 74, 0.12); color: rgba(255,255,255,0.76); font-size: 1.02rem; }
        .hero-list { display: grid; gap: 0.9rem; }
        .hero-item { padding: 1rem 1.05rem; border: 1px solid rgba(255,255,255,0.08); border-radius: 1.15rem; background: rgba(255,255,255,0.06); }
        .auth-panel { padding: 3rem; background: rgba(255,255,255,0.9); }
        .auth-panel-header { margin-bottom: 1.8rem; }
        .auth-panel-header h2 { margin-bottom: 0.5rem; font-family: "Space Grotesk", sans-serif; font-size: 2rem; letter-spacing: -0.04em; color: #132238; }
        .auth-panel-header p { margin: 0; color: #617089; }
        .alert-login { border: 1px solid rgba(212, 93, 63, 0.18); border-radius: 1rem; background: rgba(212, 93, 63, 0.08); color: #9d4029; }
        .form-label { margin-bottom: 0.55rem; font-size: 0.92rem; font-weight: 700; color: #132238; }
        .input-shell { position: relative; }
        .input-shell i { position: absolute; top: 50%; left: 1rem; transform: translateY(-50%); color: #617089; font-size: 0.98rem; }
        .input-shell .form-control { min-height: 3.55rem; padding: 0.95rem 1rem 0.95rem 2.8rem; border: 1px solid rgba(19,34,56,0.12); border-radius: 1.15rem; background: #fff; color: #132238; box-shadow: none; }
        .input-shell .form-control:focus { border-color: rgba(20,130,122,0.48); box-shadow: 0 0 0 0.25rem rgba(20,130,122,0.12); }
        .btn-login { width: 100%; min-height: 3.65rem; border: 0; border-radius: 1.2rem; background: linear-gradient(135deg, #14827a, #1d6fb1); color: #fff; font-weight: 800; letter-spacing: 0.02em; box-shadow: 0 18px 34px rgba(20,130,122,0.24); }
        .btn-login:hover, .btn-login:focus { color: #fff; }
        .auth-caption { margin-top: 1.2rem; color: #617089; font-size: 0.88rem; text-align: center; }
        @media (max-width: 991.98px) { .auth-shell { grid-template-columns: 1fr; } .auth-hero, .auth-panel { padding: 2rem; } .auth-hero h1 { max-width: none; } }
    </style>
</head>
<body class="inventory-shell">
    <div class="page-orb orb-one"></div>
    <div class="page-orb orb-two"></div>
    <main class="auth-stage">
        <section class="auth-shell">
            <div class="auth-hero">
                <div class="hero-brand">
                    <div class="hero-brand-icon"><i class="bi bi-bag-check"></i></div>
                    <div><strong>Inventory Store</strong><br><span>Buyer access</span></div>
                </div>
                <span class="hero-eyebrow">Buyer Login</span>
                <h1>Pick up where your shopping left off.</h1>
                <p class="hero-copy">Sign in to manage your cart, place orders, and track purchases from your buyer dashboard.</p>
                <div class="hero-list">
                    <div class="hero-item">Built for customer accounts only.</div>
                    <div class="hero-item">Admin and staff should still use the main login page.</div>
                </div>
            </div>
            <div class="auth-panel">
                <div class="auth-panel-header">
                    <h2>Buyer sign in</h2>
                    <p>Use your email, contact number, or username to continue to the store dashboard.</p>
                </div>
                <?php if (session()->getFlashdata('msg')): ?>
                    <div class="alert alert-login mb-4" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i><?= session()->getFlashdata('msg') ?>
                    </div>
                <?php endif; ?>
                <form action="<?= site_url('buyer/login') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="username" class="form-label">Email, Contact, or Username</label>
                        <div class="input-shell">
                            <i class="bi bi-person"></i>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter your email, contact, or username" value="<?= esc(old('username')) ?>" required autofocus>
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
                        <i class="bi bi-box-arrow-in-right me-2"></i>Buyer Sign In
                    </button>
                </form>
                <p class="auth-caption mb-2">Need an account? <a href="<?= site_url('buyer/register') ?>">Register as a buyer</a></p>
            </div>
        </section>
    </main>
</body>
</html>
