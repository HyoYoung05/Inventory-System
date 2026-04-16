<?= $this->extend('layouts/staff_layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <a href="<?= base_url('staff/products') ?>" class="btn btn-sm btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Back to Products
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="mb-0"><i class="bi bi-info-circle"></i> Product Details</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-3">Product Information</h5>
                <table class="table table-borderless">
                    <tr>
                        <td class="fw-bold">SKU:</td>
                        <td><code><?= esc($product['sku']) ?></code></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Product Name:</td>
                        <td><?= esc($product['name']) ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Description:</td>
                        <td><?= esc($product['description'] ?? 'N/A') ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Price:</td>
                        <td><strong>₱<?= number_format($product['price'], 2) ?></strong></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h5 class="mb-3">Stock Information</h5>
                <table class="table table-borderless">
                    <tr>
                        <td class="fw-bold">Stock Quantity:</td>
                        <td>
                            <?php 
                                if ($product['stock_quantity'] > 20) {
                                    $class = 'bg-success';
                                    $status = 'In Stock';
                                } elseif ($product['stock_quantity'] > 0) {
                                    $class = 'bg-warning';
                                    $status = 'Low Stock';
                                } else {
                                    $class = 'bg-danger';
                                    $status = 'Out of Stock';
                                }
                            ?>
                            <span class="badge <?= $class ?>"><?= $product['stock_quantity'] ?> units</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Status:</td>
                        <td>
                            <span class="badge <?= $class ?>">
                                <?= $status ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Created At:</td>
                        <td><?= date('M d, Y H:i', strtotime($product['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Last Updated:</td>
                        <td><?= date('M d, Y H:i', strtotime($product['updated_at'])) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
