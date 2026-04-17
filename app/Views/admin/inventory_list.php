<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3><i class="bi bi-box-seam"></i> Inventory Management</h3>
                <p class="text-muted mb-0">View inventory and edit product details.</p>
            </div>
            <a href="<?= site_url('admin/inventory/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Product
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form action="<?= site_url('admin/inventory') ?>" method="get" class="d-flex gap-2 flex-wrap">
            <input type="text" name="search" class="form-control" placeholder="Search by SKU or product name..." value="<?= esc($search ?? '') ?>">
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Search
            </button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No products found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <?php
                            $stock = (int) $product['stock_quantity'];
                            $statusLabel = $stock > 20 ? 'In Stock' : ($stock > 0 ? 'Low Stock' : 'Out of Stock');
                            $statusClass = $stock > 20 ? 'bg-success' : ($stock > 0 ? 'bg-warning text-dark' : 'bg-danger');
                        ?>
                        <tr>
                            <td><code><?= esc($product['sku']) ?></code></td>
                            <td>
                                <strong><?= esc($product['name']) ?></strong>
                                <?php if (!empty($product['description'])): ?>
                                    <br>
                                    <small class="text-muted"><?= esc(substr($product['description'], 0, 70)) ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($product['category_name'] ?? 'N/A') ?></td>
                            <td><strong>&#8369;<?= number_format((float) $product['price'], 2) ?></strong></td>
                            <td><?= $stock ?> unit<?= $stock === 1 ? '' : 's' ?></td>
                            <td><span class="badge <?= $statusClass ?>"><?= $statusLabel ?></span></td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="<?= site_url('admin/inventory/edit/' . $product['id']) ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form method="POST" action="<?= site_url('admin/inventory/delete/' . $product['id']) ?>" onsubmit="return confirm('Delete this product? This action cannot be undone.');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>




