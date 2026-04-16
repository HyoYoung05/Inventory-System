<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; min-height: 100vh;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4">Inventory System</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?= base_url('admin/dashboard') ?>" class="nav-link text-white">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/inventory') ?>" class="nav-link text-white">
                <i class="bi bi-box-seam"></i> Products
            </a>
        </li>
        <li>
            <a href="<?= base_url('admin/categories') ?>" class="nav-link text-white">
                <i class="bi bi-tags"></i> Categories
            </a>
        </li>
        <li>
            <a href="<?= base_url('staff/orders') ?>" class="nav-link text-white">
                <i class="bi bi-cart-check"></i> Orders
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="<?= base_url('logout') ?>" class="btn btn-danger w-100">
            <strong>Logout</strong>
        </a>
    </div>
</div>
</body>
</html>